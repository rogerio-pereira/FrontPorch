<?php

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;

beforeEach()->flaky();

it('smoke tests the portfolio page', function () {
    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                    ]);

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->cover()
        ->create([
            'url' => '/images/portfolio-study-case/cover.png',
        ]);

    visit('/portfolio')
        ->assertSee('Case studies that show the path')
        ->assertPresent('@portfolio-heading')
        ->assertPresent('@portfolio-case-0')
        ->assertSee('From missed calls to booked jobs');
});

it('shows the empty state when there are no case studies', function () {
    visit('/portfolio')
        ->assertPresent('@portfolio-empty')
        ->assertSee('Case studies coming soon');
});
