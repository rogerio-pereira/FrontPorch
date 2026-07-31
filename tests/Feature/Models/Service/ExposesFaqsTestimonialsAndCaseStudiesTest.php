<?php

use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;

it('exposes faqs testimonials and case studies', function () {
    $service = Service::factory()
                    ->create([
                        'sort_order' => 3,
                    ]);

    $lastFaq = Faq::factory()
                ->create([
                    'service_id' => $service->id,
                    'sort_order' => 2,
                ]);

    $firstFaq = Faq::factory()
                    ->create([
                        'service_id' => $service->id,
                        'sort_order' => 1,
                    ]);

    $testimonial = Testimonial::factory()
                        ->create([
                            'service_id' => $service->id,
                        ]);

    $caseStudy = CaseStudy::factory()
                    ->create();

    $service->caseStudies()->attach($caseStudy);

    $faqIds = $service->faqs->pluck('id')->all();
    $testimonialIds = $service->testimonials->pluck('id')->all();
    $caseStudyIds = $service->caseStudies->pluck('id')->all();

    expect($service->sort_order)->toBe(3);
    expect($faqIds)->toBe([$firstFaq->id, $lastFaq->id]);
    expect($testimonialIds)->toBe([$testimonial->id]);
    expect($caseStudyIds)->toBe([$caseStudy->id]);
});
