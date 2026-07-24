<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        /*
         * TODO: replace demo arrays with Eloquent / CMS queries.
         *
         * Expected Inertia props:
         * - faq: list<{ question: string, answer: string }>
         * - services: list<{ slug: string, title: string, teaser: string }>
         * - testimonials: list<{ quote: string, attribution: string }>
         * - portfolioPreview: list<{ title: string, description: string, image: string }>
         * - blogPreview: list<{ title: string, description: string, image: string }>
         */
        return Inertia::render('home/Home', [
            'faq' => $this->faq(),
            'services' => $this->services(),
            'testimonials' => $this->testimonials(),
            'portfolioPreview' => $this->portfolioPreview(),
            'blogPreview' => $this->blogPreview(),
        ]);
    }

    /**
     * @return list<array{question: string, answer: string}>
     */
    private function faq(): array
    {
        return [
            [
                'question' => 'You are a new agency, why should I trust you?',
                'answer' => 'That is a fair question. We are honest about being early-stage, and we would rather earn your trust through good communication and real results than big promises. Our founders have years of experience in software, automation, and marketing. This agency is how we bring that work to small businesses in a personal, down-to-earth way.',
            ],
            [
                'question' => 'I already have a website. Do I still need you?',
                'answer' => 'Maybe, maybe not a full rebuild. Plenty of sites look fine but do not bring in leads, work well on phones, or connect to the rest of your tools. We will take an honest look and suggest what actually makes sense for you. Sometimes a small fix goes further than starting over.',
            ],
            [
                'question' => 'Where do you work with clients?',
                'answer' => 'We are based in Plant City, Florida, and focus on small businesses in Central Florida, roughly within 60 miles, including areas like Tampa, Lakeland, Brandon, Wesley Chapel, and Sarasota. Being local helps us understand your market. For the right fit, we can work remotely too.',
            ],
            [
                'question' => 'How much does this cost?',
                'answer' => 'It depends on what you need: a landing page is different from a full custom build. After a discovery call, we send a written proposal with clear pricing. We aim for options that fit small-business budgets and actually move the needle.',
            ],
            [
                'question' => 'What exactly am I buying?',
                'answer' => 'Think of it as help growing your business, not just a one-off deliverable. That might mean a website people trust, emails that bring people back, ads that bring real inquiries, or tools that save you hours every week. We walk through everything in plain language before you decide.',
            ],
            [
                'question' => 'How long until I see results?',
                'answer' => 'Some things help quickly: a better site, smoother follow-ups, less manual work. Other pieces, like steady lead flow and search visibility, usually take a couple of months to build momentum. We will be upfront about what to expect and keep you posted along the way.',
            ],
            [
                'question' => 'Do I need to be good with technology?',
                'answer' => 'Not at all. Most of our clients are business owners, not tech people. We do the heavy lifting and explain things so you feel confident, never confused.',
            ],
            [
                'question' => 'Is paid advertising worth it for a small business?',
                'answer' => 'It can be, when it is targeted and tied to a clear offer. We help you understand what you are paying for, start with a budget that feels safe, and track whether inquiries are actually coming in. If ads are not the right fit yet, we will say so.',
            ],
            [
                'question' => 'What happens on a discovery call?',
                'answer' => 'It is a relaxed chat, like sitting on a front porch, not a sales interrogation. We ask about your business, you ask us anything, and we see if there is a good fit. No obligation either way.',
            ],
        ];
    }

    /**
     * @return list<array{slug: string, title: string, teaser: string}>
     */
    private function services(): array
    {
        return [
            [
                'slug' => 'lead-generation',
                'title' => 'Lead generation',
                'teaser' => 'Reach the right people with a clear reason to reach out, not another ignored ad.',
            ],
            [
                'slug' => 'email-marketing',
                'title' => 'Email marketing',
                'teaser' => 'Stay in touch in a personal way so customers remember you and come back.',
            ],
            [
                'slug' => 'website-design-and-development',
                'title' => 'Website design & development',
                'teaser' => 'A site that looks good, loads fast on phones, and makes the next step easy.',
            ],
            [
                'slug' => 'business-automations',
                'title' => 'Business automations',
                'teaser' => 'Let the repetitive stuff run itself so you can focus on customers.',
            ],
            [
                'slug' => 'custom-software-development',
                'title' => 'Custom software development',
                'teaser' => 'When ready-made tools do not fit, we build something that does.',
            ],
        ];
    }

    /**
     * @return list<array{quote: string, attribution: string}>
     */
    private function testimonials(): array
    {
        return [
            [
                'quote' => 'They actually listened, and explained things in a way that made sense.',
                'attribution' => 'What we aim for',
            ],
            [
                'quote' => 'We always knew what was happening next. No surprises.',
                'attribution' => 'What we aim for',
            ],
        ];
    }

    /**
     * @return list<array{title: string, description: string, image: string}>
     */
    private function portfolioPreview(): array
    {
        return [
            [
                'title' => 'Website for a local service business',
                'description' => 'A clean, mobile-friendly site that explains services and makes contact easy.',
                'image' => '/images/home/portfolio-a.png',
            ],
            [
                'title' => 'Lead follow-up for home services',
                'description' => 'A simple path from first click to booked appointment, without lost leads.',
                'image' => '/images/home/portfolio-b.png',
            ],
            [
                'title' => 'Email welcome series for retail',
                'description' => 'Warm emails that introduce new customers and keep them coming back.',
                'image' => '/images/home/portfolio-c.png',
            ],
            [
                'title' => 'Easier appointment booking',
                'description' => 'Forms and calendars connected so nobody re-types the same information.',
                'image' => '/images/home/portfolio-a.png',
            ],
            [
                'title' => 'Review requests after a job',
                'description' => 'A gentle nudge that helps happy customers leave a Google review.',
                'image' => '/images/home/portfolio-b.png',
            ],
            [
                'title' => 'Client portal for a firm',
                'description' => 'One place to share files and updates, with less email back-and-forth.',
                'image' => '/images/home/portfolio-c.png',
            ],
        ];
    }

    /**
     * @return list<array{title: string, description: string, image: string}>
     */
    private function blogPreview(): array
    {
        return [
            [
                'title' => 'Your website works when you are not',
                'description' => 'Most customers look you up before they call. Here is how to make that first impression count.',
                'image' => '/images/home/blog-website.png',
            ],
            [
                'title' => 'Getting more inquiries from people who are actually interested',
                'description' => 'A simple way to think about turning online attention into real conversations.',
                'image' => '/images/home/blog-inquiries.png',
            ],
            [
                'title' => 'Small automations that save big chunks of time',
                'description' => 'Start with the tasks you do every week, the relief is often immediate.',
                'image' => '/images/home/blog-automations.png',
            ],
        ];
    }
}
