<?php

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Service;
use Inertia\Testing\AssertableInertia as Assert;

it('renders a case study by slug', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                        'client' => 'Cypress & Oak Home Services',
                        'industry' => 'Home services',
                        'content' => '<p>What we built together.</p>',
                    ]);

    $caseStudy->services()
        ->attach($service);

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->create([
            'sort_order' => 0,
            'url' => '/images/portfolio-study-case/cover.png',
            'alt' => 'Homepage overview',
        ]);

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->create([
            'sort_order' => 1,
            'url' => '/images/portfolio-study-case/process.png',
            'alt' => 'Service request flow',
        ]);

    $response = $this->get('/portfolio/study-case/from-missed-calls-to-booked-jobs');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('portfolio-study-case/PortfolioStudyCase')
        ->has('caseStudy', fn (Assert $props) => $props
            ->where('title', 'From missed calls to booked jobs')
            ->where('client', 'Cypress & Oak Home Services')
            ->where('industry', 'Home services')
            ->where('content', '<p>What we built together.</p>')
            ->has('description')
            ->has('challenge')
            ->has('images', 2)
            ->where('images.0.url', '/images/portfolio-study-case/cover.png')
            ->where('images.0.alt', 'Homepage overview')
            ->where('images.1.url', '/images/portfolio-study-case/process.png')
            ->where('images.1.alt', 'Service request flow')
            ->has('services', 1)
            ->where('services.0.title', 'Lead generation')
            ->etc()
        )
    );
});

it('returns not found for unknown study cases', function () {
    $response = $this->get('/portfolio/study-case/not-a-real-case-study');

    $response->assertNotFound();
});

it('returns not found for soft deleted study cases', function () {
    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'Retired story',
                    ]);

    $caseStudy->delete();

    $response = $this->get('/portfolio/study-case/retired-story');

    $response->assertNotFound();
});
