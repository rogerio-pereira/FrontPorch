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
            ->where('service', 'Lead generation')
            ->where('coverImage', '/images/portfolio-study-case/cover.png')
            ->where('coverAlt', 'Homepage overview')
            ->where('content', '<p>What we built together.</p>')
            ->has('description')
            ->has('challenge')
            ->has('galleryImages', 1)
            ->has('galleryImages.0', fn (Assert $image) => $image
                ->where('src', '/images/portfolio-study-case/process.png')
                ->where('alt', 'Service request flow')
            )
        )
    );
});

it('falls back to the title and placeholder without gallery images', function () {
    CaseStudy::factory()
        ->create([
            'title' => 'A quiet launch',
        ]);

    $response = $this->get('/portfolio/study-case/a-quiet-launch');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('caseStudy', fn (Assert $props) => $props
            ->where('coverImage', '/images/home/portfolio-a.png')
            ->where('coverAlt', 'A quiet launch')
            ->where('service', '')
            ->has('galleryImages', 0)
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
