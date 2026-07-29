<?php

use App\Models\Service;
use App\Support\UniqueSlug;

it('considers soft deleted records', function () {
    $service = Service::factory()->create(['title' => 'Lead Generation']);
    $service->delete();

    expect(UniqueSlug::uniqueSlug('Lead Generation', Service::class))->toBe('lead-generation-2');
});
