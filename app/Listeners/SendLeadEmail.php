<?php

namespace App\Listeners;

use App\Events\ContactLeadSubmitted;
use App\Mail\LeadEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendLeadEmail
{
    private const EMAIL_MAX_ATTEMPTS = 3;

    public function handle(ContactLeadSubmitted $event): void
    {
        $recipient = config('site.contact_email');

        if (! is_string($recipient) || $recipient === '') {
            Log::warning('Lead email skipped: CONTACT_EMAIL is not configured.');

            return;
        }

        $attempt = 1;

        while ($attempt <= self::EMAIL_MAX_ATTEMPTS) {
            try {
                $mail = new LeadEmail($event->lead);

                Mail::to($recipient)
                    ->send($mail);

                Log::info('Lead email sent.', [
                    'recipient' => $recipient,
                    'lead_email' => $event->lead['email'],
                    'attempt' => $attempt,
                ]);

                return;
            } catch (Throwable $exception) {
                $context = [
                    'attempt' => $attempt,
                    'message' => $exception->getMessage(),
                    'exception' => $exception::class,
                ];

                Log::warning('Lead email attempt failed.', $context);

                $attempt++;
            }
        }

        $context = [
            'recipient' => $recipient,
            'lead_email' => $event->lead['email'],
        ];

        Log::error('Lead email failed after all retries.', $context);
    }
}
