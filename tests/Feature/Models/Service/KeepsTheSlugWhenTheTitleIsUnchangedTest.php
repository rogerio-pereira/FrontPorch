<?php

use App\Models\Service;

it('keeps the slug when the title is unchanged', function () {
    $service = Service::factory()->create(['title' => 'Business Automations']);

    $service->update(['description' => 'A refreshed blurb for the home page.']);

    expect($service->slug)->toBe('business-automations');
});
