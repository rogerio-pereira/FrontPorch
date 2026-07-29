<?php

use App\Models\Service;
use App\Support\UniqueSlug;

it('falls back to item when the title has no sluggable characters', function () {
    expect(UniqueSlug::uniqueSlug('###', Service::class))->toBe('item');
});
