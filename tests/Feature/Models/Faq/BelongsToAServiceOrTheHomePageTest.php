<?php

use App\Models\Faq;
use App\Models\Service;

it('belongs to a service or the home page', function () {
    $service = Service::factory()->create();

    $serviceFaq = Faq::factory()->forService($service)->create(['sort_order' => '5']);
    $homeFaq = Faq::factory()->forHome()->create();

    expect($serviceFaq->sort_order)->toBe(5);
    expect($serviceFaq->service->id)->toBe($service->id);
    expect($homeFaq->service_id)->toBeNull();
    expect($homeFaq->service)->toBeNull();
});
