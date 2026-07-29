<?php

use App\Models\Service;

it('derives the slug from the title on create', function () {
    $first = Service::factory()->create(['title' => 'Website Design & Development']);
    $second = Service::factory()->create(['title' => 'Website Design & Development']);

    expect($first->slug)->toBe('website-design-development');
    expect($second->slug)->toBe('website-design-development-2');
});
