<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the custom software development service landing page', function () {
    $response = $this->get('/services/custom-software-development');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('service-custom-software-development/ServiceCustomSoftwareDevelopment')
        ->has('faqs', 0)
        ->has('testimonials', 0)
    );
});

it('renders the faqs and testimonials of the custom software service', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Custom software development',
                    ]);

    Faq::factory()
        ->create([
            'service_id' => $service->id,
            'question' => 'When is custom software the right call?',
        ]);

    Testimonial::factory()
        ->create([
            'service_id' => $service->id,
            'person' => 'Founder, Central Florida logistics startup',
        ]);

    $response = $this->get('/services/custom-software-development');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('faqs', 1)
        ->has('testimonials', 1)
    );
});
