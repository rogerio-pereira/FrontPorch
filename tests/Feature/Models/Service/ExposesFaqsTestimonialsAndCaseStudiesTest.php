<?php

use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;

it('exposes faqs testimonials and case studies', function () {
    $service = Service::factory()->create(['sort_order' => '3']);

    $lastFaq = Faq::factory()->forService($service)->create(['sort_order' => 2]);
    $firstFaq = Faq::factory()->forService($service)->create(['sort_order' => 1]);

    $testimonial = Testimonial::factory()->forService($service)->create();

    $caseStudy = CaseStudy::factory()->create();
    $service->caseStudies()->attach($caseStudy);

    expect($service->sort_order)->toBe(3);
    expect($service->faqs->pluck('id')->all())->toBe([$firstFaq->id, $lastFaq->id]);
    expect($service->testimonials->pluck('id')->all())->toBe([$testimonial->id]);
    expect($service->caseStudies->pluck('id')->all())->toBe([$caseStudy->id]);
});
