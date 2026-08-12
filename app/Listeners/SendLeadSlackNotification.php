<?php

namespace App\Listeners;

use App\Events\ContactLeadSubmitted;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class SendLeadSlackNotification
{
    public function handle(ContactLeadSubmitted $event): void
    {
        $token = config('services.slack.notifications.bot_user_oauth_token');
        $channel = config('services.slack.notifications.channel');

        if (empty($token) || empty($channel)) {
            Log::warning('Lead Slack notification skipped: Slack is not configured.');

            return;
        }

        try {
            $lead = $event->lead;
            $phone = $lead['phone'];

            if (empty($phone)) {
                $phone = '(not provided)';
            }

            $website = $lead['website'];

            if (empty($website)) {
                $website = '(not provided)';
            }

            $text = "New website lead\n"
                ."Name: {$lead['name']}\n"
                ."Email: {$lead['email']}\n"
                ."Phone: {$phone}\n"
                ."Website: {$website}";

            $notification = new SlackNotification($text);

            Notification::route('slack', $channel)
                ->notify($notification);

            Log::info('Lead Slack notification sent.', [
                'lead_email' => $lead['email'],
                'channel' => $channel,
            ]);
        } catch (Throwable $exception) {
            $context = [
                'message' => $exception->getMessage(),
                'exception' => $exception::class,
                'lead_email' => $event->lead['email'],
                'channel' => $channel,
            ];

            Log::error('Lead Slack notification failed.', $context);
        }
    }
}
