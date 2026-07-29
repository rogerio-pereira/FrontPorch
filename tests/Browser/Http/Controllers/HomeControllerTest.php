<?php

use App\Models\Faq;
use App\Models\Service;

beforeEach(function () {
    Service::factory()->ordered(1)->create(['title' => 'Lead generation']);
    Service::factory()->ordered(2)->create(['title' => 'Email marketing']);
    Service::factory()->ordered(3)->create(['title' => 'Website design and development']);

    Faq::factory()->forHome()->create([
        'question' => 'You are a new agency, why should I trust you?',
        'answer' => 'That is a fair question. We would rather earn your trust than make big promises.',
        'sort_order' => 1,
    ]);
});

it('smoke tests the home page hero', function () {
    visit('/')
        ->assertSee('You do great work')
        ->assertPresent('@home-hero-headline');
});

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

it('exposes service card links on the home page', function () {
    visit('/')
        ->assertPresent('@home-service-lead-generation')
        ->assertPresent('@home-service-email-marketing')
        ->assertPresent('@home-service-website-design-and-development');
});

it('expands a faq item on the home page', function () {
    visit('/')
        ->click('@home-faq-trigger-0')
        ->assertSee('That is a fair question.');
});

it('exposes the contact anchor for navigation', function () {
    visit('/')
        ->assertPresent('@nav-contact');
});

it('exposes the contact section via hash', function () {
    visit('/#contact')
        ->assertSee('We would love to hear from you')
        ->assertPresent('@home-contact-schedule');
});
