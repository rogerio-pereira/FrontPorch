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
        ->has('relatedServices', 0)
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

it('includes other catalog services in relatedServices', function () {
    Service::factory()
        ->create([
            'title' => 'Custom software development',
            'sort_order' => 6,
        ]);

    Service::factory()
        ->create([
            'title' => 'Content creation',
            'sort_order' => 4,
        ]);

    Service::factory()
        ->create([
            'title' => 'Email marketing',
            'sort_order' => 2,
        ]);

    $response = $this->get('/services/custom-software-development');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('relatedServices', 2)
        ->where('relatedServices', [
            'email-marketing' => 'Email marketing',
            'content-creation' => 'Content creation',
        ])
    );
});
