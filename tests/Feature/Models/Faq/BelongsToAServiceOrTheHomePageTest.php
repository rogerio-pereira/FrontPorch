<?php

use App\Models\Faq;
use App\Models\Service;

it('belongs to a service or the home page', function () {
    $service = Service::factory()
                    ->create();

    $serviceFaq = Faq::factory()
                    ->create([
                        'service_id' => $service->id,
                        'sort_order' => '5',
                    ]);

    $homeFaq = Faq::factory()
                    ->create([
                        'service_id' => null,
                    ]);

    $sortOrder = $serviceFaq->sort_order;
    expect($sortOrder)->toBe(5);

    $attachedServiceId = $serviceFaq->service->id;
    expect($attachedServiceId)->toBe($service->id);

    $homeServiceId = $homeFaq->service_id;
    expect($homeServiceId)->toBeNull();

    $homeService = $homeFaq->service;
    expect($homeService)->toBeNull();
});
