<?php

use App\Mail\LeadEmail;
use App\Mail\LeadSchedulingEmail;
use App\Models\Service;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use RyanChandler\LaravelCloudflareTurnstile\Facades\Turnstile;

beforeEach(function () {
    Turnstile::fake();
    config([
        'site.contact_email' => 'leads@example.com',
        'site.calendar_url' => 'https://calendar.example.com/book',
    ]);
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

    Mail::assertSent(LeadSchedulingEmail::class, function (LeadSchedulingEmail $mail): bool {
        return $mail->hasTo('alex@example.com')
            && $mail->calendarUrl === 'https://calendar.example.com/book';
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

it('accepts a submission without website', function () {
    Mail::fake();
    Notification::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');

    Mail::assertSent(LeadEmail::class, function (LeadEmail $mail): bool {
        return $mail->lead['website'] === null
            && $mail->websiteDisplay === '(not provided)';
    });
});

it('accepts a submission with selected services', function () {
    Mail::fake();
    Notification::fake();

    $leadGeneration = Service::factory()->create([
        'title' => 'Lead generation',
        'sort_order' => 1,
    ]);
    $emailMarketing = Service::factory()->create([
        'title' => 'Email marketing',
        'sort_order' => 2,
    ]);

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'services' => [
                $emailMarketing->slug,
                $leadGeneration->slug,
            ],
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');

    Mail::assertSent(LeadEmail::class, function (LeadEmail $mail) use ($leadGeneration, $emailMarketing): bool {
        return $mail->lead['services'] === [
            $leadGeneration->title,
            $emailMarketing->title,
        ]
            && $mail->servicesDisplay === 'Lead generation, Email marketing';
    });
});

it('accepts a submission without services', function () {
    Mail::fake();
    Notification::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');

    Mail::assertSent(LeadEmail::class, function (LeadEmail $mail): bool {
        return $mail->lead['services'] === []
            && $mail->servicesDisplay === '(not provided)';
    });
});

it('rejects unknown service slugs', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'services' => ['not-a-real-service'],
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['services.0']);

    Mail::assertNothingSent();
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
    $response->assertSessionDoesntHaveErrors(['website']);

    Mail::assertNothingSent();
});

it('rejects an invalid website url', function () {
    Mail::fake();

    $response = $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'website' => 'not-a-url',
            'cf-turnstile-response' => Turnstile::dummy(),
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['website']);

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
    Mail::assertSent(LeadSchedulingEmail::class);
    Notification::assertNothingSent();
});

it('skips the scheduling email when calendar url is missing', function () {
    Mail::fake();
    Notification::fake();

    config(['site.calendar_url' => null]);

    $this->from('/')
        ->post('/contact', [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.com',
            'website' => 'https://example.com',
            'cf-turnstile-response' => Turnstile::dummy(),
        ])
        ->assertRedirect('/');

    Mail::assertSent(LeadEmail::class);
    Mail::assertNotSent(LeadSchedulingEmail::class);
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
