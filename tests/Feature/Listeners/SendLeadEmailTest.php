<?php

use App\Events\ContactLeadSubmitted;
use App\Listeners\SendLeadEmail;
use App\Mail\LeadEmail;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

function contactLeadPayload(array $overrides = []): ContactLeadSubmitted
{
    $lead = array_merge([
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => '(813) 555-0100',
        'website' => 'https://example.com',
    ], $overrides);

    return new ContactLeadSubmitted($lead);
}

it('skips sending when contact email is not configured', function () {
    Mail::fake();

    config(['site.contact_email' => '']);

    Log::shouldReceive('warning')
        ->once()
        ->with('Lead email skipped: CONTACT_EMAIL is not configured.');

    $listener = new SendLeadEmail;
    $listener->handle(contactLeadPayload());

    Mail::assertNothingSent();
});

it('retries mail failures and logs an error after all attempts', function () {
    config(['site.contact_email' => 'leads@example.com']);

    $pendingMail = Mockery::mock(PendingMail::class);
    $pendingMail->shouldReceive('send')
        ->times(3)
        ->andThrow(new RuntimeException('SMTP unavailable'));

    Mail::shouldReceive('to')
        ->times(3)
        ->with('leads@example.com')
        ->andReturn($pendingMail);

    Log::shouldReceive('warning')
        ->times(3)
        ->withArgs(function (string $message, array $context): bool {
            return $message === 'Lead email attempt failed.'
                && isset($context['attempt'])
                && $context['message'] === 'SMTP unavailable';
        });

    Log::shouldReceive('error')
        ->once()
        ->withArgs(function (string $message, array $context): bool {
            return $message === 'Lead email failed after all retries.'
                && $context['recipient'] === 'leads@example.com'
                && $context['lead_email'] === 'alex@example.com';
        });

    $listener = new SendLeadEmail;
    $listener->handle(contactLeadPayload());
});

it('sends the lead email on the first successful attempt', function () {
    Mail::fake();

    config(['site.contact_email' => 'leads@example.com']);

    $listener = new SendLeadEmail;
    $listener->handle(contactLeadPayload([
        'phone' => null,
    ]));

    Mail::assertSent(LeadEmail::class, function (LeadEmail $mail): bool {
        return $mail->hasTo('leads@example.com')
            && $mail->phoneDisplay === '(not provided)';
    });
});
