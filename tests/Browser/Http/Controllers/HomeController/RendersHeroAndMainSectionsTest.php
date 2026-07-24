<?php

it('renders the home page hero and main sections', function () {
    visit('/')
        ->assertSee('You do great work. Let\'s help more people find you.')
        ->assertPresent('@home-hero-headline')
        ->assertPresent('@home-hero-primary-cta')
        ->assertPresent('@home-hero-visual')
        ->assertSee('Good questions, happy to answer')
        ->assertPresent('@home-faq')
        ->assertPresent('@home-contact-email')
        ->assertPresent('@home-service-lead-generation');
});
