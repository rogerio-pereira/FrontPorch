<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders the home page with backend-driven listing props', function () {
    $this->get('/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('home/Home')
            ->has('faq', 9)
            ->has('faq.0', fn (Assert $item) => $item
                ->has('question')
                ->has('answer')
            )
            ->has('services', 5)
            ->has('services.0', fn (Assert $item) => $item
                ->has('slug')
                ->has('title')
                ->has('teaser')
            )
            ->has('testimonials', 2)
            ->has('testimonials.0', fn (Assert $item) => $item
                ->has('quote')
                ->has('attribution')
            )
            ->has('portfolioPreview', 6)
            ->has('portfolioPreview.0', fn (Assert $item) => $item
                ->has('title')
                ->has('description')
                ->has('image')
            )
        );
});
