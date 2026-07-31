<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Database\Seeder;

class FaqWebsiteDesignAndDevelopmentSeeder extends Seeder
{
    /**
     * Seed the FAQs shown on the website design and development service landing.
     */
    public function run(): void
    {
        $service = Service::where('slug', 'website-design-and-development')
            ->firstOrFail();

        // Rebuild vs improve
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do I need a brand-new website, or can you improve what I have?',
            ],
            [
                'answer' => 'It depends. If the bones are solid, a clearer message, better mobile experience, and stronger call to action may be enough. If the site is slow, confusing, or hard to update, a rebuild often costs less frustration in the long run. We will give you an honest recommendation.',
                'sort_order' => 1,
            ]
        );

        // Mobile
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Will my site work well on phones?',
            ],
            [
                'answer' => 'Yes. Most of your visitors will be on a phone, so we design for that first: fast loads, readable text, and an obvious next step without pinching and zooming.',
                'sort_order' => 2,
            ]
        );

        // Timeline
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How long does a website project take?',
            ],
            [
                'answer' => 'A focused landing page can move quickly; a full custom site takes longer. After we understand your goals and content readiness, we share a realistic timeline in the proposal. Delays usually come from waiting on photos, copy, or decisions, so we keep that path clear.',
                'sort_order' => 3,
            ]
        );

        // Content
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do I need to write all the copy and provide photos?',
            ],
            [
                'answer' => 'You do not have to write the copy yourself. We can write it for you, based on what you tell us about the business, using a clear and friendly voice. For photos and videos, we do not shoot or record them; you provide images from your business, or we can help when you need guidance on what works well on the site.',
                'sort_order' => 4,
            ]
        );

        // Updates
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Can I update the site myself later?',
            ],
            [
                'answer' => 'We aim for sites you can maintain without calling us for every small change. How much you edit yourself depends on the build. We show you the practical parts and stay available when you want help with bigger updates.',
                'sort_order' => 5,
            ]
        );

        // SEO
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Will a new website get me to the top of Google?',
            ],
            [
                'answer' => 'A clear, fast, well-structured site is the foundation for local search, but rankings also need ongoing content and relevance. We build with SEO basics in mind and can talk separately about lead generation or our content creation service (blog posts and social writing) if you want more visibility over time.',
                'sort_order' => 6,
            ]
        );

        // Cost clarity
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How is pricing decided for a website?',
            ],
            [
                'answer' => 'By scope: number of pages, custom features, content help, and integrations. After a discovery call we send a written proposal with clear pricing so you know what you are buying before anything starts.',
                'sort_order' => 7,
            ]
        );

        // AI in the build
        Faq::where('service_id', $service->id)
            ->where('question', 'Do you use AI for website copy?')
            ->delete();

        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do you use AI when building my website?',
            ],
            [
                'answer' => 'Yes. We may use AI to assist and speed up development and drafting so your site moves faster without cutting corners. Everything is human-reviewed before it ships: design choices, code, and copy. The finished site should still feel like a clear conversation with your business, not a generic AI brochure.',
                'sort_order' => 8,
            ]
        );
    }
}
