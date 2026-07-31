<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqHomeSeeder extends Seeder
{
    /**
     * Seed the FAQs shown on the home page (no service attached).
     */
    public function run(): void
    {
        // Trust / new agency
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'You are a new agency, why should I trust you?',
            ],
            [
                'answer' => 'That is a fair question. We are honest about being early-stage, and we would rather earn your trust through good communication and real results than big promises. Our founders have years of experience in software, automation, and marketing. This agency is how we bring that work to small businesses in a personal, down-to-earth way.',
                'sort_order' => 1,
            ]
        );

        // Existing website
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'I already have a website. Do I still need you?',
            ],
            [
                'answer' => 'Maybe, maybe not a full rebuild. Plenty of sites look fine but do not bring in leads, work well on phones, or connect to the rest of your tools. We will take an honest look and suggest what actually makes sense for you. Sometimes a small fix goes further than starting over.',
                'sort_order' => 2,
            ]
        );

        // Service area
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'Where do you work with clients?',
            ],
            [
                'answer' => 'We are based in Plant City, Florida, and focus on small businesses in Central Florida, roughly within 60 miles, including areas like Tampa, Lakeland, Brandon, Wesley Chapel, and Sarasota. Being local helps us understand your market. For the right fit, we can work remotely too.',
                'sort_order' => 3,
            ]
        );

        // Pricing
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'How much does this cost?',
            ],
            [
                'answer' => 'It depends on what you need: a landing page is different from a full custom build. After a discovery call, we send a written proposal with clear pricing. We aim for options that fit small-business budgets and actually move the needle.',
                'sort_order' => 4,
            ]
        );

        // What you buy
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'What exactly am I buying?',
            ],
            [
                'answer' => 'Think of it as help growing your business, not just a one-off deliverable. That might mean a website people trust, emails that bring people back, ads that bring real inquiries, or tools that save you hours every week. We walk through everything in plain language before you decide.',
                'sort_order' => 5,
            ]
        );

        // Timeline
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'How long until I see results?',
            ],
            [
                'answer' => 'Some things help quickly: a better site, smoother follow-ups, less manual work. Other pieces, like steady lead flow and search visibility, usually take a couple of months to build momentum. We will be upfront about what to expect and keep you posted along the way.',
                'sort_order' => 6,
            ]
        );

        // Tech comfort
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'Do I need to be good with technology?',
            ],
            [
                'answer' => 'Not at all. Most of our clients are business owners, not tech people. We do the heavy lifting and explain things so you feel confident, never confused.',
                'sort_order' => 7,
            ]
        );

        // Paid ads
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'Is paid advertising worth it for a small business?',
            ],
            [
                'answer' => 'It can be, when it is targeted and tied to a clear offer. We help you understand what you are paying for, start with a budget that feels safe, and track whether inquiries are actually coming in. If ads are not the right fit yet, we will say so.',
                'sort_order' => 8,
            ]
        );

        // Discovery call
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'What happens on a discovery call?',
            ],
            [
                'answer' => 'It is a relaxed chat, like sitting on a front porch, not a sales interrogation. We ask about your business, you ask us anything, and we see if there is a good fit. No obligation either way.',
                'sort_order' => 9,
            ]
        );

        // AI use
        Faq::updateOrCreate(
            [
                'service_id' => null,
                'question' => 'Do you use AI in your work?',
            ],
            [
                'answer' => 'Yes. We use AI as a helper for drafts, research, and speeding up the boring parts of marketing and build work. A human still shapes the strategy, reviews the words, and makes the decisions that affect your business. Tools do not replace judgment on the front porch.',
                'sort_order' => 10,
            ]
        );
    }
}
