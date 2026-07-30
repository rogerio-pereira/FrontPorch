<?php

use App\Models\Service;
use App\Models\Testimonial;

it('belongs to a service', function () {
    $service = Service::factory()
                    ->create();

    $testimonial = Testimonial::factory()
                    ->create([
                        'service_id' => $service->id,
                    ]);

    $attachedServiceId = $testimonial->service->id;
    expect($attachedServiceId)->toBe($service->id);
});
