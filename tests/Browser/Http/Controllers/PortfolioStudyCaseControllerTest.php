<?php

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Service;

it('smoke tests the portfolio study case page', function () {
    $service = Service::factory()->create(['title' => 'Lead generation']);

    $caseStudy = CaseStudy::factory()->create([
        'title' => 'From missed calls to booked jobs',
        'content' => '<p>We designed a mobile-first site.</p>',
    ]);

    $caseStudy->services()->attach($service);

    CaseStudyImage::factory()->for($caseStudy)->create([
        'sort_order' => 0,
        'url' => '/images/portfolio-study-case/cover.png',
    ]);

    CaseStudyImage::factory()->for($caseStudy)->create([
        'sort_order' => 1,
        'url' => '/images/portfolio-study-case/process.png',
    ]);

    visit('/portfolio/study-case/from-missed-calls-to-booked-jobs')
        ->assertSee('From missed calls to booked jobs')
        ->assertPresent('@study-case-heading')
        ->assertPresent('@study-case-services')
        ->assertPresent('@study-case-challenge')
        ->assertPresent('@study-case-solution')
        ->assertPresent('@study-case-carousel')
        ->assertPresent('@study-case-content')
        ->assertSee('We designed a mobile-first site.')
        ->assertPresent('@study-case-cta');
});
