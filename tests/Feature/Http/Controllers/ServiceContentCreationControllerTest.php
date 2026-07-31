<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the content creation service landing page', function () {
    $response = $this->get('/services/content-creation');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('service-content-creation/ServiceContentCreation')
        ->has('faqs', 0)
        ->has('testimonials', 0)
    );
});

it('renders the faqs and testimonials of the content creation service', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Content creation',
                    ]);

    Faq::factory()
        ->create([
            'service_id' => $service->id,
            'question' => 'Do you take photos or record videos?',
        ]);

    Testimonial::factory()
        ->create([
            'service_id' => $service->id,
            'person' => 'Owner, Plant City cafe',
        ]);

    $response = $this->get('/services/content-creation');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('faqs', 1)
        ->has('testimonials', 1)
    );
});
