<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the website design and development service landing page', function () {
    $response = $this->get('/services/website-design-and-development');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('service-website-design-and-development/ServiceWebsiteDesignAndDevelopment')
        ->has('faqs', 0)
        ->has('testimonials', 0)
    );
});

it('renders the faqs and testimonials of the website service', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Website design and development',
                    ]);

    Faq::factory()
        ->create([
            'service_id' => $service->id,
            'question' => 'How long does a new site take?',
        ]);

    Testimonial::factory()
        ->create([
            'service_id' => $service->id,
            'person' => 'Manager, Brandon dental office',
        ]);

    $response = $this->get('/services/website-design-and-development');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('faqs', 1)
        ->has('testimonials', 1)
    );
});
