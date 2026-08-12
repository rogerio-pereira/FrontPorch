<?php

use App\Events\ContactLeadSubmitted;
use App\Listeners\SendLeadEmail;
use App\Listeners\SendLeadSchedulingEmail;
use App\Listeners\SendLeadSlackNotification;
use App\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Event;

it('disables automatic event discovery', function () {
    $provider = new EventServiceProvider($this->app);

    expect($provider->shouldDiscoverEvents())->toBeFalse();
});

it('registers contact lead listeners explicitly', function () {
    Event::fake();

    Event::assertListening(
        ContactLeadSubmitted::class,
        SendLeadEmail::class,
    );

    Event::assertListening(
        ContactLeadSubmitted::class,
        SendLeadSchedulingEmail::class,
    );

    Event::assertListening(
        ContactLeadSubmitted::class,
        SendLeadSlackNotification::class,
    );
});

it('exposes the contact lead listeners in the provider map', function () {
    $provider = new EventServiceProvider($this->app);
    $listen = $provider->listens();

    expect($listen)->toHaveKey(ContactLeadSubmitted::class);
    expect($listen[ContactLeadSubmitted::class])->toBe([
        SendLeadEmail::class,
        SendLeadSchedulingEmail::class,
        SendLeadSlackNotification::class,
    ]);
});
