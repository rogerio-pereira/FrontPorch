<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Database\Seeder;

class FaqEmailMarketingSeeder extends Seeder
{
    /**
     * Seed the FAQs shown on the email marketing service landing.
     */
    public function run(): void
    {
        $service = Service::where('slug', 'email-marketing')
            ->firstOrFail();

        // Why email
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Is email marketing still worth it for a small business?',
            ],
            [
                'answer' => 'Yes, when it feels personal. Social posts disappear fast; email lands where people already check every day. A welcome note, a kind follow-up, or a useful update keeps you memorable between visits without sounding spammy.',
                'sort_order' => 1,
            ]
        );

        // List size
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'I only have a small email list. Does that matter?',
            ],
            [
                'answer' => 'A small list of real customers is often better than a huge cold one. We start with who already knows you, then grow the list naturally through your site, forms, and offers. Quality beats volume.',
                'sort_order' => 2,
            ]
        );

        // Writing
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do you write the emails for me?',
            ],
            [
                'answer' => 'We can. Many owners want the strategy, sequences, and copy drafted in a friendly voice that still sounds like them. You review and approve before anything goes out.',
                'sort_order' => 3,
            ]
        );

        // Tools
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do I need a fancy email platform first?',
            ],
            [
                'answer' => 'Not necessarily. We work with practical tools that fit small businesses and help you set them up cleanly. If you already have a platform, we usually build on what you have instead of forcing a big switch.',
                'sort_order' => 4,
            ]
        );

        // Frequency
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How often should I email my customers?',
            ],
            [
                'answer' => 'Enough to stay useful, not enough to annoy. For many local businesses that means a welcome series, timely follow-ups, and occasional updates, not daily blasts. We match the rhythm to your customers and your capacity.',
                'sort_order' => 5,
            ]
        );

        // Spam worry
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Will this make me sound like a robot or a spammer?',
            ],
            [
                'answer' => 'That is exactly what we avoid. Tone matters as much as timing. We write like a human sitting on a front porch: clear, warm, and easy to ignore if it is not relevant, with an honest unsubscribe always available.',
                'sort_order' => 6,
            ]
        );

        // Results
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What results should I expect from email?',
            ],
            [
                'answer' => 'Stronger follow-up, more return visits, and fewer warm leads going quiet. Exact numbers depend on your list and offer. We track opens, clicks, and replies in plain language so you can see what is working.',
                'sort_order' => 7,
            ]
        );
    }
}
