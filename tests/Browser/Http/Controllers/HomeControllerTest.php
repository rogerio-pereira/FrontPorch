<?php

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Faq;
use App\Models\Service;

beforeEach(function () {
    Service::factory()
        ->create([
            'title' => 'Lead generation',
            'sort_order' => 1,
        ]);

    Service::factory()
        ->create([
            'title' => 'Email marketing',
            'sort_order' => 2,
        ]);

    Service::factory()
        ->create([
            'title' => 'Website design and development',
            'sort_order' => 3,
        ]);
});

it('hides faq, testimonials, and blog sections when the database is empty', function () {
    visit('/')
        ->assertDontSee('Good questions, happy to answer')
        ->assertNotPresent('@home-faq')
        ->assertDontSee('Client stories')
        ->assertDontSee('What people say about working with us')
        ->assertDontSee('From the blog')
        ->assertDontSee('Ideas worth sharing')
        ->assertNotPresent('@home-cta-2')
        ->assertNotPresent('@home-cta-3')
        ->assertDontSee('A little clarity goes a long way')
        ->assertDontSee('You should not need a tech degree to grow your business')
        ->assertPresent('@home-hero-headline');
});

it('smoke tests the home page hero', function () {
    visit('/')
        ->assertSee('You do great work')
        ->assertPresent('@home-hero-headline');
});

it('renders the home page hero and main sections', function () {
    Faq::factory()
        ->create([
            'service_id' => null,
            'question' => 'You are a new agency, why should I trust you?',
            'answer' => 'That is a fair question. We would rather earn your trust than make big promises.',
            'sort_order' => 1,
        ]);

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
    Faq::factory()
        ->create([
            'service_id' => null,
            'question' => 'You are a new agency, why should I trust you?',
            'answer' => 'That is a fair question. We would rather earn your trust than make big promises.',
            'sort_order' => 1,
        ]);

    visit('/')
        ->click('@home-faq-trigger-0')
        ->assertSee('That is a fair question.');
});

it('links home blog cards to the article page', function () {
    BlogArticle::factory()
        ->create([
            'title' => 'Why your website should feel like a front porch',
        ]);

    visit('/')
        ->assertPresent('@home-blog-article-0')
        ->click('@home-blog-article-0')
        ->assertPathIs('/blog/article/why-your-website-should-feel-like-a-front-porch')
        ->assertSee('Why your website should feel like a front porch');
});

it('links home portfolio cards to the case study page', function () {
    $service = Service::where('title', 'Lead generation')
                    ->firstOrFail();

    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                    ]);

    $caseStudy->services()
        ->attach($service);

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->cover()
        ->create([
            'url' => '/images/home/portfolio-b.png',
        ]);

    visit('/')
        ->assertPresent('@home-portfolio-case-0')
        ->assertSee('Lead generation')
        ->assertPresent('@home-portfolio-case-services-0')
        ->click('@home-portfolio-case-0')
        ->assertPathIs('/portfolio/study-case/from-missed-calls-to-booked-jobs')
        ->assertSee('From missed calls to booked jobs');
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
