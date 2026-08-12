<?php

use App\Mail\LeadEmail;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use RyanChandler\LaravelCloudflareTurnstile\Facades\Turnstile;

beforeEach(function () {
    Service::factory()
        ->create([
            'title' => 'Lead generation',
            'sort_order' => 1,
        ]);

    Turnstile::fake();
    config(['site.contact_email' => 'leads@example.com']);
    Notification::fake();
})->flaky();

it('submits the home contact form successfully', function () {
    Mail::fake();

    $service = Service::query()->firstOrFail();

    visit('/')
        ->assertPresent('@contact-form')
        ->assertPresent('@contact-submit')
        ->assertPresent('@contact-services')
        ->assertSee('We will email you the discovery-call link.')
        ->type('name', 'Alex Rivera')
        ->type('email', 'alex@example.com')
        ->type('website', 'https://example.com')
        ->type('phone', '(813) 555-0100')
        ->click('@contact-services-trigger')
        ->click('@contact-services-option-'.$service->slug)
        ->click('@contact-submit')
        ->assertPathIs('/');

    Mail::assertSent(LeadEmail::class, function (LeadEmail $mail) use ($service): bool {
        return $mail->lead['services'] === $service->title;
    });
});
