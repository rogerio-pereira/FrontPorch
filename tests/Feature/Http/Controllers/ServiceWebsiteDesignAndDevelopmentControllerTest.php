<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the website design and development service landing page', function () {
    $this->get('/services/website-design-and-development')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-website-design-and-development/ServiceWebsiteDesignAndDevelopment')
            ->has('faqs', 0)
            ->has('testimonials', 0)
        );
});

it('renders the faqs and testimonials of the website service', function () {
    $service = Service::factory()->create(['title' => 'Website design and development']);

    Faq::factory()->forService($service)->create(['question' => 'How long does a new site take?']);
    Testimonial::factory()->forService($service)->create(['person' => 'Manager, Brandon dental office']);

    $this->get('/services/website-design-and-development')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('faqs', 1)
            ->has('testimonials', 1)
        );
});
