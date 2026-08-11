<?php

namespace App\Listeners;

use App\Events\ContactLeadSubmitted;
use App\Mail\LeadSchedulingEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendLeadSchedulingEmail
{
    private const EMAIL_MAX_ATTEMPTS = 3;

    public function handle(ContactLeadSubmitted $event): void
    {
        $calendarUrl = config('site.calendar_url');

        if (! is_string($calendarUrl) || $calendarUrl === '') {
            Log::warning('Lead scheduling email skipped: CALENDAR_URL is not configured.');

            return;
        }

        $recipient = $event->lead['email'];
        $attempt = 1;

        while ($attempt <= self::EMAIL_MAX_ATTEMPTS) {
            try {
                $mail = new LeadSchedulingEmail($event->lead, $calendarUrl);

                Mail::to($recipient)
                    ->send($mail);

                return;
            } catch (Throwable $exception) {
                $message = $exception->getMessage();

                $context = [
                    'attempt' => $attempt,
                    'message' => $message,
                ];

                Log::warning('Lead scheduling email attempt failed.', $context);

                $attempt++;
            }
        }

        $context = [
            'recipient' => $recipient,
            'calendar_url' => $calendarUrl,
        ];

        Log::error('Lead scheduling email failed after all retries.', $context);
    }
}
