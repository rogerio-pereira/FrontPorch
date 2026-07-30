<?php

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Service;
use Inertia\Testing\AssertableInertia as Assert;

it('renders portfolio listing from case studies', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Website design & development',
                    ]);

    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                        'description' => 'How a Central Florida home services company booked more jobs.',
                        'client' => 'Cypress & Oak Home Services',
                    ]);

    $caseStudy->services()
        ->attach($service);

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->cover()
        ->create([
            'url' => '/images/portfolio-study-case/cover.png',
            'alt' => 'Homepage overview',
        ]);

    $response = $this->get('/portfolio');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('portfolio/Portfolio')
        ->has('caseStudies.data', 1)
        ->has('caseStudies.data.0', fn (Assert $item) => $item
            ->where('id', $caseStudy->id)
            ->where('title', 'From missed calls to booked jobs')
            ->where('description', 'How a Central Florida home services company booked more jobs.')
            ->where('client', 'Cypress & Oak Home Services')
            ->where('slug', 'from-missed-calls-to-booked-jobs')
            ->has('images', 1)
            ->where('images.0.url', '/images/portfolio-study-case/cover.png')
            ->has('services', 1)
            ->where('services.0.title', 'Website design & development')
            ->etc()
        )
        ->where('caseStudies.current_page', 1)
        ->where('caseStudies.last_page', 1)
        ->where('caseStudies.prev_page_url', null)
        ->where('caseStudies.next_page_url', null)
    );
});

it('paginates the portfolio at fifteen case studies per page', function () {
    CaseStudy::factory(16)
        ->has(CaseStudyImage::factory()->cover(), 'images')
        ->create();

    $response = $this->get('/portfolio');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('caseStudies.data', 15)
        ->where('caseStudies.current_page', 1)
        ->where('caseStudies.last_page', 2)
        ->where('caseStudies.prev_page_url', null)
        ->has('caseStudies.next_page_url')
    );
});

it('hides soft deleted case studies from the portfolio', function () {
    $caseStudy = CaseStudy::factory()
                    ->create();

    $caseStudy->delete();

    $response = $this->get('/portfolio');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page->has('caseStudies.data', 0));
});
