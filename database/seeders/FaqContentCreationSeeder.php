<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Database\Seeder;

class FaqContentCreationSeeder extends Seeder
{
    /**
     * Seed the FAQs shown on the content creation service landing.
     */
    public function run(): void
    {
        $service = Service::where('slug', 'content-creation')
            ->firstOrFail();

        // What it includes
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What does content creation include?',
            ],
            [
                'answer' => 'Written content that helps people find and trust you: blog posts for your website, and posts and captions for the social platforms you already use. We focus on clear, friendly writing that sounds like your business, not generic marketing speak.',
                'sort_order' => 1,
            ]
        );

        // What it does not include
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do you take photos or record videos?',
            ],
            [
                'answer' => 'No. We do not shoot photos or record video. You provide any images from your business when a post needs them, or we write text-first posts that work well without custom photography. If you need guidance on what kinds of images perform better, we can advise.',
                'sort_order' => 2,
            ]
        );

        // Blog vs social
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do I need a blog, social posts, or both?',
            ],
            [
                'answer' => 'It depends on your goals. A blog helps with search and deeper explanations. Social posts keep you visible between visits. Many small businesses benefit from both at a sustainable pace. We will recommend a mix that fits your capacity, not a schedule you cannot keep.',
                'sort_order' => 3,
            ]
        );

        // Frequency
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How often will you publish?',
            ],
            [
                'answer' => 'We agree on a realistic cadence up front, for example a couple of blog posts a month plus a steady set of social captions. Consistency matters more than posting every day. The plan goes in writing so you know what to expect.',
                'sort_order' => 4,
            ]
        );

        // Platforms
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Which social platforms do you write for?',
            ],
            [
                'answer' => 'The ones your customers already use and that you are willing to maintain. Commonly that means Facebook, Instagram captions, LinkedIn, or similar. We will not push you onto every network. Better to do a few platforms well than many poorly.',
                'sort_order' => 5,
            ]
        );

        // Voice and approval
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Will the writing sound like my business?',
            ],
            [
                'answer' => 'Yes. We learn your voice from a short discovery chat and any examples you like. You review drafts before anything goes live, and we revise until it feels right. You stay the final say on what gets published.',
                'sort_order' => 6,
            ]
        );

        // SEO
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Will blog posts help me rank on Google?',
            ],
            [
                'answer' => 'Thoughtful, useful posts about what you offer and the questions customers ask can support local and topic search over time. They are not a magic overnight ranking switch. We write for real readers first, with search basics in mind, and pair well with a solid website.',
                'sort_order' => 7,
            ]
        );

        // Fit with other services
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How does this work with my website or ads?',
            ],
            [
                'answer' => 'Content supports both. Blog posts give your site something worth ranking and sharing. Social posts keep attention warm between campaigns. If you also use lead generation or email marketing, we can align topics so the message stays consistent across channels.',
                'sort_order' => 8,
            ]
        );

        // AI drafting
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do you use AI to write my content?',
            ],
            [
                'answer' => 'Yes, as a drafting aid. AI helps us move faster on first drafts and ideas so you get more consistent publishing without waiting weeks. We also use AI to automate posting on a defined schedule, so your content goes out when it should without you having to remember. Every piece still gets human editing for voice, accuracy, and whether it actually sounds like your business. Nothing goes live until you approve it.',
                'sort_order' => 9,
            ]
        );
    }
}
