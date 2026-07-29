<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the business automations service landing page', function () {
    $this->get('/services/business-automations')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-business-automations/ServiceBusinessAutomations')
            ->has('faqs', 0)
            ->has('testimonials', 0)
        );
});

it('renders the faqs and testimonials of the business automations service', function () {
    $service = Service::factory()->create(['title' => 'Business automations']);

    Faq::factory()->forService($service)->create(['question' => 'What should we automate first?']);
    Testimonial::factory()->forService($service)->create(['person' => 'Owner, Wesley Chapel cleaning service']);

    $this->get('/services/business-automations')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('faqs', 1)
            ->has('testimonials', 1)
        );
});
