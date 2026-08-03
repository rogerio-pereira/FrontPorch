<?php

use App\Mail\LeadNotification;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use RyanChandler\LaravelCloudflareTurnstile\Facades\Turnstile;

beforeEach(function () {
    Service::factory()
        ->create([
            'title' => 'Lead generation',
            'sort_order' => 1,
        ]);

    Turnstile::fake();
});

it('submits the home contact form successfully', function () {
    Mail::fake();

    visit('/')
        ->assertPresent('@contact-form')
        ->assertPresent('@home-contact-schedule')
        ->type('name', 'Alex Rivera')
        ->type('email', 'alex@example.com')
        ->type('phone', '8135550100')
        ->click('@contact-submit')
        ->assertPathIs('/');

    Mail::assertSent(LeadNotification::class);
});
