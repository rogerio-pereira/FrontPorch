<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders the portfolio study case from backend props', function () {
    $this->get('/portfolio/study-case/1')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('portfolio-study-case/PortfolioStudyCase')
            ->has('caseStudy', fn (Assert $caseStudy) => $caseStudy
                ->has('title')
                ->has('client')
                ->has('location')
                ->has('service')
                ->has('industry')
                ->has('coverImage')
                ->has('coverAlt')
                ->has('intro')
                ->has('challenge')
                ->has('solution')
                ->has('quote')
                ->has('quoteAttribution')
                ->has('closing')
                ->has('solutionImages', 4)
                ->where('client', 'Cypress & Oak Home Services')
            )
        );
});
