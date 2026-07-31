<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the business automations service landing page', function () {
    $response = $this->get('/services/business-automations');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('service-business-automations/ServiceBusinessAutomations')
        ->has('faqs', 0)
        ->has('testimonials', 0)
    );
});

it('renders the faqs and testimonials of the business automations service', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Business automations',
                    ]);

    Faq::factory()
        ->create([
            'service_id' => $service->id,
            'question' => 'What should we automate first?',
        ]);

    Testimonial::factory()
        ->create([
            'service_id' => $service->id,
            'person' => 'Owner, Wesley Chapel cleaning service',
        ]);

    $response = $this->get('/services/business-automations');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('faqs', 1)
        ->has('testimonials', 1)
    );
});
