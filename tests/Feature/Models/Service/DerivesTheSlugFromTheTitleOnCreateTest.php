<?php

use App\Models\Service;

it('derives the slug from the title on create', function () {
    $service = Service::factory()->create([
        'title' => 'Website Design & Development',
    ]);

    expect($service->slug)->toBe('website-design-development');
});
