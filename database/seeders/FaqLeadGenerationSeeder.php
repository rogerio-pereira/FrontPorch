<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Database\Seeder;

class FaqLeadGenerationSeeder extends Seeder
{
    /**
     * Seed the FAQs shown on the lead generation service landing.
     */
    public function run(): void
    {
        $service = Service::where('slug', 'lead-generation')
            ->firstOrFail();

        // What it means
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What does lead generation mean for a small business like mine?',
            ],
            [
                'answer' => 'It means getting more of the right people to reach out: calls, form fills, or booked chats from folks who actually need what you offer. We focus on real inquiries, not vanity clicks or empty traffic.',
                'sort_order' => 1,
            ]
        );

        // Ads vs organic
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do I have to run paid ads?',
            ],
            [
                'answer' => 'For most small businesses that want a steady flow of new inquiries, paid ads are the practical engine. A stronger landing page, local search, and follow-up help ads convert better, but they rarely replace paid reach on their own, especially when you need results in weeks rather than months. If ads are clearly the wrong fit for your situation, we will say so, without pretending organic alone is a free shortcut.',
                'sort_order' => 2,
            ]
        );

        // Who runs the ads
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do you run the ads for me?',
            ],
            [
                'answer' => 'Yes, when paid advertising is part of the plan. We set up, launch, and monitor campaigns, then adjust based on what brings real conversations. You stay in the loop with plain-language updates.',
                'sort_order' => 3,
            ]
        );

        // Platform spend vs service fee
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Why do I have to pay Google or Facebook and your service separately?',
            ],
            [
                'answer' => 'They are two different costs. Ad spend goes straight to Google, Meta, or whichever platform shows your ads. Our fee covers strategy, setup, creative direction, tracking, optimization, and reporting. Think of it like fuel versus the mechanic: the platforms charge to put your offer in front of people; we make sure that spend is aimed well and worth running.',
                'sort_order' => 4,
            ]
        );

        // Budget
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How much budget do I need to start?',
            ],
            [
                'answer' => 'A solid starting point for many small businesses is about $300 to $500 per month in ad spend, paid directly to Google or Meta. That can be higher or lower depending on your market, competition, offer, and how quickly you want to learn. We recommend a number after a discovery call and put it in writing so you know what you are committing to.',
                'sort_order' => 5,
            ]
        );

        // Results timeline
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How soon will I see leads?',
            ],
            [
                'answer' => 'Paid campaigns can bring inquiries within days or weeks when the offer and landing page are solid. Organic and local search usually take longer to build momentum. We set expectations up front so you know what is realistic.',
                'sort_order' => 6,
            ]
        );

        // Existing website
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'I already have a website. Can you still help with leads?',
            ],
            [
                'answer' => 'Absolutely. Many clients keep their current site and we improve the path from attention to inquiry: clearer offers, landing pages, ads, and follow-up. If the site itself is holding leads back, we will say so honestly, and if a fresher build would serve you better, we can help with that too.',
                'sort_order' => 7,
            ]
        );

        // Fit
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What if lead generation is not the right first step for me?',
            ],
            [
                'answer' => 'Then we will say so. Sometimes email follow-up, a stronger website, or a simple automation unlocks more value first. A discovery call is there to find the honest next step, not to force a package.',
                'sort_order' => 8,
            ]
        );

        // AI for ads
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do you use AI for ads and lead generation?',
            ],
            [
                'answer' => 'Yes. We may use AI to draft headlines, ad variations, or landing-page ideas faster, and also to help understand performance and suggest or automate campaign improvements over time. A human still sets strategy, reviews what goes live, and decides where budget goes, with plain-language reporting so you always know what is happening.',
                'sort_order' => 9,
            ]
        );
    }
}
