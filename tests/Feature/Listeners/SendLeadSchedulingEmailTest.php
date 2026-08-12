<?php

use App\Events\ContactLeadSubmitted;
use App\Listeners\SendLeadSchedulingEmail;
use App\Mail\LeadSchedulingEmail;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

function schedulingLeadPayload(array $overrides = []): ContactLeadSubmitted
{
    $lead = array_merge([
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => '(813) 555-0100',
        'website' => 'https://example.com',
        'services' => 'Lead generation',
    ], $overrides);

    return new ContactLeadSubmitted($lead);
}

it('skips sending when calendar url is not configured', function () {
    Mail::fake();

    config(['site.calendar_url' => '']);

    Log::shouldReceive('warning')
        ->once()
        ->with('Lead scheduling email skipped: CALENDAR_URL is not configured.');

    $listener = new SendLeadSchedulingEmail;
    $listener->handle(schedulingLeadPayload());

    Mail::assertNothingSent();
});

it('retries mail failures and logs an error after all attempts', function () {
    config(['site.calendar_url' => 'https://calendar.example.com/book']);

    $pendingMail = Mockery::mock(PendingMail::class);
    $pendingMail->shouldReceive('send')
        ->times(3)
        ->andThrow(new RuntimeException('SMTP unavailable'));

    Mail::shouldReceive('to')
        ->times(3)
        ->with('alex@example.com')
        ->andReturn($pendingMail);

    Log::shouldReceive('warning')
        ->times(3)
        ->withArgs(function (string $message, array $context): bool {
            return $message === 'Lead scheduling email attempt failed.'
                && isset($context['attempt'])
                && $context['message'] === 'SMTP unavailable';
        });

    Log::shouldReceive('error')
        ->once()
        ->withArgs(function (string $message, array $context): bool {
            return $message === 'Lead scheduling email failed after all retries.'
                && $context['recipient'] === 'alex@example.com'
                && $context['calendar_url'] === 'https://calendar.example.com/book';
        });

    $listener = new SendLeadSchedulingEmail;
    $listener->handle(schedulingLeadPayload());
});

it('sends the scheduling email to the lead on the first successful attempt', function () {
    Mail::fake();

    config(['site.calendar_url' => 'https://calendar.example.com/book']);

    $listener = new SendLeadSchedulingEmail;
    $listener->handle(schedulingLeadPayload());

    Mail::assertSent(LeadSchedulingEmail::class, function (LeadSchedulingEmail $mail): bool {
        return $mail->hasTo('alex@example.com')
            && $mail->calendarUrl === 'https://calendar.example.com/book'
            && $mail->lead['name'] === 'Alex Rivera';
    });
});
