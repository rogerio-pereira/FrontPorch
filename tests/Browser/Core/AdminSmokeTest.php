<?php

use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;

it('shows the admin indexes to authenticated users', function (string $url, string $heading) {
    $this->actingAs(User::factory()->create());

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($heading);
})->with([
    ['/core/services', 'Services'],
    ['/core/faqs', 'FAQs'],
    ['/core/testimonials', 'Testimonials'],
    ['/core/case-studies', 'Case studies'],
]);

it('shows the admin create forms to authenticated users', function (string $url, string $heading, string $submit) {
    $this->actingAs(User::factory()->create());

    Service::factory()->create(['title' => 'Lead generation']);

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($heading)
        ->assertPresent($submit);
})->with([
    ['/core/services/create', 'New service', '@service-submit'],
    ['/core/faqs/create', 'New FAQ', '@faq-submit'],
    ['/core/testimonials/create', 'New testimonial', '@testimonial-submit'],
    ['/core/case-studies/create', 'New case study', '@case-study-submit'],
]);

it('shows the admin edit forms to authenticated users', function (string $url, string $heading, string $submit) {
    $this->actingAs(User::factory()->create());

    $service = Service::factory()->create(['title' => 'Lead generation']);
    $faq = Faq::factory()->forService($service)->create(['question' => 'How soon can we start?']);
    $testimonial = Testimonial::factory()->forService($service)->create(['person' => 'Jordan Client']);
    $caseStudy = CaseStudy::factory()->create(['title' => 'From missed calls to booked jobs']);

    $resolvedUrl = str_replace(
        ['{service}', '{faq}', '{testimonial}', '{caseStudy}'],
        [$service->id, $faq->id, $testimonial->id, $caseStudy->id],
        $url,
    );

    visit($resolvedUrl)
        ->waitForEvent('networkidle')
        ->assertSee($heading)
        ->assertPresent($submit);
})->with([
    ['/core/services/{service}/edit', 'Edit service', '@service-submit'],
    ['/core/faqs/{faq}/edit', 'Edit FAQ', '@faq-submit'],
    ['/core/testimonials/{testimonial}/edit', 'Edit testimonial', '@testimonial-submit'],
    ['/core/case-studies/{caseStudy}/edit', 'Edit case study', '@case-study-submit'],
]);
