<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    public function __invoke(): Response
    {
        /*
         * TODO: replace with CaseStudy::published()->latest()->get() (or equivalent).
         *
         * Expected Inertia prop `items`:
         * list<{
         *   id: int,
         *   title: string,
         *   excerpt: string,
         *   client: string,
         *   service: string,
         *   coverImage: string,
         *   href: string,
         * }>
         *
         * Empty list → Portfolio page shows the empty state.
         */
        $items = [
            [
                'id' => 1,
                'title' => 'From missed calls to booked jobs',
                'excerpt' => 'How a Central Florida home services company turned a quiet website into a reliable source of appointments.',
                'client' => 'Cypress & Oak Home Services',
                'service' => 'Website design & lead follow-up',
                'coverImage' => '/images/portfolio/case-study-cover.png',
                'href' => '/portfolio/study-case/1',
            ],
        ];

        return Inertia::render('portfolio/Portfolio', [
            'items' => $items,
        ]);
    }
}
