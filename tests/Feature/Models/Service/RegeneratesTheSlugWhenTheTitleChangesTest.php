<?php

use App\Models\Service;

it('regenerates the slug when the title changes', function () {
    $service = Service::factory()->create(['title' => 'Lead Generation']);

    $service->update(['title' => 'Email Marketing']);

    expect($service->slug)->toBe('email-marketing');
});
