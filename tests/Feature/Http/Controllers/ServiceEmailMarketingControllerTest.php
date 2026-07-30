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
