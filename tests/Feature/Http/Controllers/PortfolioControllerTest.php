<?php

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Service;
use Inertia\Testing\AssertableInertia as Assert;

it('renders portfolio listing from case studies', function () {
    $service = Service::factory()->create(['title' => 'Website design & development']);

    $caseStudy = CaseStudy::factory()->create([
        'title' => 'From missed calls to booked jobs',
        'description' => 'How a Central Florida home services company booked more jobs.',
        'client' => 'Cypress & Oak Home Services',
    ]);

    $caseStudy->services()->attach($service);

    CaseStudyImage::factory()->for($caseStudy)->cover()->create([
        'url' => '/images/portfolio-study-case/cover.png',
    ]);

    $this->get('/portfolio')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('portfolio/Portfolio')
            ->has('items', 1)
            ->has('items.0', fn (Assert $item) => $item
                ->where('id', $caseStudy->id)
                ->where('title', 'From missed calls to booked jobs')
                ->where('excerpt', 'How a Central Florida home services company booked more jobs.')
                ->where('client', 'Cypress & Oak Home Services')
                ->where('service', 'Website design & development')
                ->where('coverImage', '/images/portfolio-study-case/cover.png')
                ->where('href', '/portfolio/study-case/from-missed-calls-to-booked-jobs')
            )
            ->has('pagination', fn (Assert $pagination) => $pagination
                ->where('currentPage', 1)
                ->where('lastPage', 1)
                ->where('previousPageUrl', null)
                ->where('nextPageUrl', null)
            )
        );
});

it('paginates the portfolio at fifteen case studies per page', function () {
    CaseStudy::factory(16)->create();

    $this->get('/portfolio')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('items', 15)
            ->has('pagination', fn (Assert $pagination) => $pagination
                ->where('currentPage', 1)
                ->where('lastPage', 2)
                ->where('previousPageUrl', null)
                ->has('nextPageUrl')
            )
        );
});

it('hides soft deleted case studies from the portfolio', function () {
    CaseStudy::factory()->softDeleted()->create();

    $this->get('/portfolio')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->has('items', 0));
});
