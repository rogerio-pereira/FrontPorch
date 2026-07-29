<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the email marketing service landing page', function () {
    $this->get('/services/email-marketing')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-email-marketing/ServiceEmailMarketing')
            ->has('faqs', 0)
            ->has('testimonials', 0)
        );
});

it('renders the faqs and testimonials of the email marketing service', function () {
    $service = Service::factory()->create(['title' => 'Email marketing']);

    Faq::factory()->forService($service)->create(['question' => 'How often should we email customers?']);
    Testimonial::factory()->forService($service)->create(['person' => 'Owner, Lakeland boutique']);

    $this->get('/services/email-marketing')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('faqs', 1)
            ->has('testimonials', 1)
        );
});
