<?php

namespace App\Services;

use App\Mail\LeadNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class LeadSubmissionService
{
    private const EMAIL_MAX_ATTEMPTS = 3;

    /**
     * @param  array{name: string, email: string, phone: string|null}  $lead
     */
    public function submit(array $lead): void
    {
        // CRM integration is under development. When wired, call it here first and
        // fail the request if CRM fails.

        $this->sendEmail($lead);
        $this->notifySlack($lead);
    }

    /**
     * @param  array{name: string, email: string, phone: string|null}  $lead
     */
    private function sendEmail(array $lead): void
    {
        $recipient = config('site.contact_email');

        if (! is_string($recipient) || $recipient === '') {
            Log::warning('Lead email skipped: CONTACT_EMAIL is not configured.');

            return;
        }

        $attempt = 1;

        while ($attempt <= self::EMAIL_MAX_ATTEMPTS) {
            try {
                $mail = new LeadNotification($lead);

                Mail::to($recipient)
                    ->send($mail);

                return;
            } catch (Throwable $exception) {
                Log::warning('Lead email attempt failed.', [
                    'attempt' => $attempt,
                    'message' => $exception->getMessage(),
                ]);

                $attempt++;
            }
        }

        Log::error('Lead email failed after all retries.', [
            'recipient' => $recipient,
            'lead_email' => $lead['email'],
        ]);
    }

    /**
     * @param  array{name: string, email: string, phone: string|null}  $lead
     */
    private function notifySlack(array $lead): void
    {
        $token = config('services.slack.notifications.bot_user_oauth_token');
        $channel = config('services.slack.notifications.channel');

        if (! is_string($token) || $token === '') {
            return;
        }

        if (! is_string($channel) || $channel === '') {
            return;
        }

        $phone = $lead['phone'];

        if ($phone === null || $phone === '') {
            $phoneLine = 'Phone: (not provided)';
        } else {
            $phoneLine = 'Phone: '.$phone;
        }

        $text = "New website lead\n"
            ."Name: {$lead['name']}\n"
            ."Email: {$lead['email']}\n"
            .$phoneLine;

        try {
            $response = Http::withToken($token)
                            ->post('https://slack.com/api/chat.postMessage', [
                                'channel' => $channel,
                                'text' => $text,
                            ]);

            if (! $response->successful()) {
                Log::warning('Slack lead notification HTTP request failed.', [
                    'status' => $response->status(),
                ]);

                return;
            }

            $ok = $response->json('ok');

            if ($ok !== true) {
                Log::warning('Slack lead notification API returned an error.', [
                    'error' => $response->json('error'),
                ]);
            }
        } catch (Throwable $exception) {
            Log::warning('Slack lead notification failed.', [
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
