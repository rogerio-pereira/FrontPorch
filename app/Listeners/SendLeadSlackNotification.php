<?php

namespace App\Listeners;

use App\Events\ContactLeadSubmitted;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;

class SendLeadSlackNotification
{
    public function handle(ContactLeadSubmitted $event): void
    {
        $token = config('services.slack.notifications.bot_user_oauth_token');
        $channel = config('services.slack.notifications.channel');

        if (empty($token) || empty($channel)) {
            return;
        }

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
            ."Website: {$website}\n"
            ."Services: {$lead['servicesDisplay']}";

        $notification = new SlackNotification($text);

        Notification::route('slack', $channel)
            ->notify($notification);
    }
}
