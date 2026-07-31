<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the lead generation service landing page', function () {
    $response = $this->get('/services/lead-generation');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('service-lead-generation/ServiceLeadGeneration')
        ->has('faqs', 0)
        ->has('testimonials', 0)
    );
});

it('renders the faqs and testimonials of the lead generation service', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    Faq::factory()
        ->create([
            'service_id' => $service->id,
            'question' => 'How many leads should I expect?',
        ]);

    Faq::factory()
        ->create([
            'service_id' => null,
        ]);

    Testimonial::factory()
        ->create([
            'service_id' => $service->id,
            'person' => 'Owner, Plant City lawn care',
        ]);

    Testimonial::factory()
        ->create();

    $response = $this->get('/services/lead-generation');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('faqs', 1)
        ->has('faqs.0', fn (Assert $faq) => $faq
            ->where('question', 'How many leads should I expect?')
            ->has('answer')
            ->etc()
        )
        ->has('testimonials', 1)
        ->has('testimonials.0', fn (Assert $testimonial) => $testimonial
            ->where('person', 'Owner, Plant City lawn care')
            ->has('testimonial')
            ->etc()
        )
    );
});

it('caps testimonials on the lead generation service landing at ten', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    Testimonial::factory(12)
        ->create([
            'service_id' => $service->id,
        ]);

    $response = $this->get('/services/lead-generation');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page->has('testimonials', 10));
});
