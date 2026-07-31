<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the email marketing service landing page', function () {
    $response = $this->get('/services/email-marketing');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('service-email-marketing/ServiceEmailMarketing')
        ->has('faqs', 0)
        ->has('testimonials', 0)
        ->has('relatedServices', 0)
    );
});

it('renders the faqs and testimonials of the email marketing service', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Email marketing',
                    ]);

    Faq::factory()
        ->create([
            'service_id' => $service->id,
            'question' => 'How often should we email customers?',
        ]);

    Testimonial::factory()
        ->create([
            'service_id' => $service->id,
            'person' => 'Owner, Lakeland boutique',
        ]);

    $response = $this->get('/services/email-marketing');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('faqs', 1)
        ->has('testimonials', 1)
    );
});

it('includes other catalog services in relatedServices', function () {
    Service::factory()
        ->create([
            'title' => 'Email marketing',
            'sort_order' => 2,
        ]);

    Service::factory()
        ->create([
            'title' => 'Lead generation',
            'sort_order' => 1,
        ]);

    Service::factory()
        ->create([
            'title' => 'Content creation',
            'sort_order' => 4,
        ]);

    $response = $this->get('/services/email-marketing');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('relatedServices', 2)
        ->where('relatedServices', [
            'lead-generation' => 'Lead generation',
            'content-creation' => 'Content creation',
        ])
    );
});
