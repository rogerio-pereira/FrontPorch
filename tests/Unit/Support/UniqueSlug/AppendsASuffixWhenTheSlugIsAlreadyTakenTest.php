<?php

use App\Models\Service;
use App\Support\UniqueSlug;

it('appends a suffix when the slug is already taken', function () {
    Service::factory()->create(['title' => 'Email Marketing']);
    Service::factory()->create(['title' => 'Email Marketing']);

    expect(UniqueSlug::uniqueSlug('Email Marketing', Service::class))->toBe('email-marketing-3');
});
