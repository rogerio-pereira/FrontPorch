<?php

use App\Mail\LeadNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use RyanChandler\LaravelCloudflareTurnstile\Facades\Turnstile;

beforeEach(function () {
    Turnstile::fake();
});

it('accepts a valid contact submission and sends email', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'phone' => '(813) 555-0100',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');

    Mail::assertSent(LeadNotification::class, function (LeadNotification $mail): bool {
        return $mail->lead['name'] === 'Alex Rivera'
            && $mail->lead['email'] === 'alex@example.com'
            && $mail->lead['phone'] === '(813) 555-0100'
            && $mail->hasTo('leads@example.com');
    });
});

it('accepts a submission without phone', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');

    Mail::assertSent(LeadNotification::class, function (LeadNotification $mail): bool {
        return $mail->lead['phone'] === null;
    });
});

it('validates required name and email', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['name', 'email']);

    Mail::assertNothingSent();
});

it('rejects an invalid us phone number', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'phone' => '123',
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
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['cf-turnstile-response']);

    Mail::assertNothingSent();
});

it('notifies slack when configured', function () {
    Mail::fake();

    config([
        'services.slack.notifications.bot_user_oauth_token' => 'xoxb-test-token',
        'services.slack.notifications.channel' => '#leads',
    ]);

    Http::fake([
        'slack.com/api/chat.postMessage' => Http::response([
            'ok' => true,
        ]),
    ]);

    $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ])
        ->assertRedirect('/');

    Http::assertSent(function ($request): bool {
        if ($request->url() !== 'https://slack.com/api/chat.postMessage') {
            return false;
        }

        return $request['channel'] === '#leads'
            && str_contains((string) $request['text'], 'Alex Rivera');
    });
});

it('skips slack when token is missing', function () {
    Mail::fake();

    config([
        'services.slack.notifications.bot_user_oauth_token' => null,
        'services.slack.notifications.channel' => '#leads',
    ]);

    $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ])
        ->assertRedirect('/');

    Mail::assertSent(LeadNotification::class);
});

it('throttles contact submissions', function () {
    Mail::fake();

    for ($i = 0; $i < 5; $i++) {
        $this->from('/')
            ->post('/contact', [
                'name' => 'Alex Rivera',
                'email' => 'alex@example.com',
                'cf-turnstile-response' => Turnstile::dummy(),
            ])
            ->assertRedirect('/');
    }

    $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ])
        ->assertStatus(429);
});
