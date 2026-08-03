<?php

use App\Mail\LeadEmail;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use RyanChandler\LaravelCloudflareTurnstile\Facades\Turnstile;

beforeEach(function () {
    Turnstile::fake();
    config(['site.contact_email' => 'leads@example.com']);
});

it('accepts a valid contact submission and sends email', function () {
    Mail::fake();
    Notification::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'phone' => '(813) 555-0100',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');

    Mail::assertSent(LeadEmail::class, function (LeadEmail $mail): bool {
        return $mail->lead['name'] === 'Alex Rivera'
            && $mail->lead['email'] === 'alex@example.com'
            && $mail->lead['phone'] === '(813) 555-0100'
            && $mail->lead['website'] === 'https://example.com'
            && $mail->hasTo('leads@example.com');
    });
});

it('accepts a submission without phone', function () {
    Mail::fake();
    Notification::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');

    Mail::assertSent(LeadEmail::class, function (LeadEmail $mail): bool {
        return $mail->lead['phone'] === null
            && $mail->phoneDisplay === '(not provided)';
    });
});

it('validates required name email and website', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['name', 'email', 'website']);

    Mail::assertNothingSent();
});

it('rejects an invalid us phone number', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'phone' => '123',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['phone']);

    Mail::assertNothingSent();
});

it('rejects phone numbers outside the (555) 555-5555 format', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'phone' => '813-555-0100',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['phone']);

    Mail::assertNothingSent();
});

it('rejects when turnstile verification fails', function () {
    Mail::fake();

    Turnstile::fake()->fail();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['cf-turnstile-response']);

    Mail::assertNothingSent();
});

it('notifies slack when configured', function () {
    Mail::fake();
    Notification::fake();

    config([
        'services.slack.notifications.bot_user_oauth_token' => 'xoxb-test-token',
        'services.slack.notifications.channel' => '#leads',
    ]);

    $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ])
        ->assertRedirect('/');

    Notification::assertSentOnDemand(SlackNotification::class, function (SlackNotification $notification, array $channels, object $notifiable): bool {
        return isset($notifiable->routes['slack'])
            && $notifiable->routes['slack'] === '#leads';
    });
});

it('skips slack when token is missing', function () {
    Mail::fake();
    Notification::fake();

    config([
        'services.slack.notifications.bot_user_oauth_token' => null,
        'services.slack.notifications.channel' => '#leads',
    ]);

    $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ])
        ->assertRedirect('/');

    Mail::assertSent(LeadEmail::class);
    Notification::assertNothingSent();
});

it('throttles contact submissions', function () {
    Mail::fake();
    Notification::fake();

    for ($i = 0; $i < 3; $i++) {
        $this->from('/')
            ->post('/contact', [
                'name' => 'Alex Rivera',
                'email' => 'alex@example.com',
                'website' => 'https://example.com',
                'cf-turnstile-response' => Turnstile::dummy(),
            ])
            ->assertRedirect('/');
    }

    $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ])
        ->assertStatus(429);
});
