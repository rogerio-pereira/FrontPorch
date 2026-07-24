<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PortfolioStudyCaseController extends Controller
{
    public function __invoke(int $id): Response
    {
        /*
         * TODO: replace with CaseStudy::findOrFail($id) (or equivalent).
         *
         * Expected Inertia prop `caseStudy`:
         * {
         *   title: string,
         *   client: string,
         *   location: string,
         *   service: string,
         *   industry: string,
         *   coverImage: string,
         *   coverAlt: string,
         *   intro: string,
         *   challenge: string,
         *   solution: string,
         *   quote: string,
         *   quoteAttribution: string,
         *   closing: string,
         *   solutionImages: list<{ src: string, alt: string }>,
         * }
         */
        if ($id !== 1) {
            abort(404);
        }

        return Inertia::render('portfolio-study-case/PortfolioStudyCase', [
            'caseStudy' => [
                'title' => 'From missed calls to booked jobs',
                'client' => 'Cypress & Oak Home Services',
                'location' => 'Plant City, Florida',
                'service' => 'Website design & lead follow-up',
                'industry' => 'Home services',
                'coverImage' => '/images/portfolio-study-case/cover.png',
                'coverAlt' => 'Abstract geometric visual representing a redesigned website and clearer customer journey',
                'intro' => 'Cypress & Oak did excellent work in the field, but online, interested homeowners often left without booking. Together we rebuilt their digital front porch so the next step felt obvious.',
                'challenge' => 'The team was busy on jobsites, yet evenings still meant digging through voicemails, Facebook messages, and half-filled contact forms. Their website looked dated on phones, buried the phone number, and offered no clear path to request service. Good leads cooled off before anyone could reply.',
                'solution' => "We started with a discovery conversation about how they actually win work, not a wishlist of features. Then we designed a mobile-first site that explains services in plain English, surfaces trust signals, and makes booking the easiest action on every page.\n\nThe homepage answers “Can you help me?” within a few seconds. Service pages match how homeowners search. A simple request form connects to email alerts and a shared calendar hold, with a short follow-up sequence so no inquiry sits unanswered overnight.",
                'quote' => 'We finally feel like our website works while we are out on jobs. People find us, ask for help, and we know exactly what to do next.',
                'quoteAttribution' => 'Owner, Cypress & Oak Home Services',
                'closing' => 'This project was never about a flashy redesign. It was about giving a local team a front porch online, welcoming, clear, and ready when a neighbor needs help.',
                'solutionImages' => [
                    [
                        'src' => '/images/portfolio-study-case/cover.png',
                        'alt' => 'Homepage overview for Cypress & Oak Home Services',
                    ],
                    [
                        'src' => '/images/portfolio-study-case/process.png',
                        'alt' => 'Service request flow connecting inquiries to booked appointments',
                    ],
                    [
                        'src' => '/images/portfolio-study-case/gallery-a.png',
                        'alt' => 'Services page layout for homeowners searching on mobile',
                    ],
                    [
                        'src' => '/images/portfolio-study-case/gallery-b.png',
                        'alt' => 'Contact and booking page with a clear next step',
                    ],
                ],
            ],
        ]);
    }
}
