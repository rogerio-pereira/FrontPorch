<?php

use App\Models\Service;
use App\Support\UniqueSlug;

it('ignores the given record', function () {
    $service = Service::factory()->create(['title' => 'Lead Generation']);

    expect(UniqueSlug::uniqueSlug('Lead Generation', Service::class, $service->id))->toBe('lead-generation');
});
