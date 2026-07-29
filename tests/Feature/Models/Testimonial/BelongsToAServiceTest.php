<?php

use App\Models\Service;
use App\Models\Testimonial;

it('belongs to a service', function () {
    $service = Service::factory()->create();

    $testimonial = Testimonial::factory()->forService($service)->create();

    expect($testimonial->service->id)->toBe($service->id);
});
