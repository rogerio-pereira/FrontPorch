<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the lead generation service landing page', function () {
    $this->get('/services/lead-generation')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-lead-generation/ServiceLeadGeneration')
            ->has('faqs', 0)
            ->has('testimonials', 0)
        );
});

it('renders the faqs and testimonials of the lead generation service', function () {
    $service = Service::factory()->create(['title' => 'Lead generation']);

    Faq::factory()->forService($service)->create(['question' => 'How many leads should I expect?']);
    Faq::factory()->forHome()->create();
    Testimonial::factory()->forService($service)->create(['person' => 'Owner, Plant City lawn care']);
    Testimonial::factory()->create();

    $this->get('/services/lead-generation')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('faqs', 1)
            ->has('faqs.0', fn (Assert $faq) => $faq
                ->where('question', 'How many leads should I expect?')
                ->has('answer')
            )
            ->has('testimonials', 1)
            ->has('testimonials.0', fn (Assert $testimonial) => $testimonial
                ->where('attribution', 'Owner, Plant City lawn care')
                ->has('quote')
            )
        );
});
