<?php

use App\Events\ContactLeadSubmitted;
use App\Listeners\SendLeadSlackNotification;
use App\Notifications\SlackNotification;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

function slackLeadPayload(array $overrides = []): ContactLeadSubmitted
{
    $lead = array_merge([
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => '(813) 555-0100',
        'website' => 'https://example.com',
    ], $overrides);

    return new ContactLeadSubmitted($lead);
}

it('skips sending when slack is not configured', function () {
    Notification::fake();

    config([
        'services.slack.notifications.bot_user_oauth_token' => '',
        'services.slack.notifications.channel' => '',
    ]);

    Log::shouldReceive('warning')
        ->once()
        ->with('Lead Slack notification skipped: Slack is not configured.');

    $listener = new SendLeadSlackNotification;
    $listener->handle(slackLeadPayload());

    Notification::assertNothingSent();
});

it('sends the slack notification when configured', function () {
    Notification::fake();

    config([
        'services.slack.notifications.bot_user_oauth_token' => 'xoxb-test-token',
        'services.slack.notifications.channel' => '#leads',
    ]);

    Log::shouldReceive('info')
        ->once()
        ->withArgs(function (string $message, array $context): bool {
            return $message === 'Lead Slack notification sent.'
                && $context['lead_email'] === 'alex@example.com'
                && $context['channel'] === '#leads';
        });

    $listener = new SendLeadSlackNotification;
    $listener->handle(slackLeadPayload([
        'phone' => null,
        'website' => null,
    ]));

    Notification::assertSentOnDemand(SlackNotification::class);
});

it('logs an error when the slack notification fails', function () {
    config([
        'services.slack.notifications.bot_user_oauth_token' => 'xoxb-test-token',
        'services.slack.notifications.channel' => '#leads',
    ]);

    $this->mock(ChannelManager::class, function ($mock): void {
        $mock->shouldReceive('send')
            ->once()
            ->andThrow(new RuntimeException('Slack API unavailable'));
    });

    Log::shouldReceive('error')
        ->once()
        ->withArgs(function (string $message, array $context): bool {
            return $message === 'Lead Slack notification failed.'
                && $context['message'] === 'Slack API unavailable'
                && $context['exception'] === RuntimeException::class
                && $context['lead_email'] === 'alex@example.com'
                && $context['channel'] === '#leads';
        });

    $listener = new SendLeadSlackNotification;
    $listener->handle(slackLeadPayload());
});
