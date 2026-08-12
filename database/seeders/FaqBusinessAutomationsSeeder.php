<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Database\Seeder;

class FaqBusinessAutomationsSeeder extends Seeder
{
    /**
     * Seed the FAQs shown on the business automations service landing.
     */
    public function run(): void
    {
        $service = Service::where('slug', 'business-automations')
            ->firstOrFail();

        // What it is
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What counts as a business automation?',
            ],
            [
                'answer' => 'Any repetitive task a computer can handle so you do not have to. Common examples: an automatic reply when someone fills out a form, a reminder before an appointment, or sending a new lead into your contact list. The goal is simple: less busywork, fewer things falling through the cracks, and more time with customers.',
                'sort_order' => 1,
            ]
        );

        // Tools
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do I need to buy new software first?',
            ],
            [
                'answer' => 'Not always. We often start with the tools you already use. If a new app would help, we explain the cost (some are free) and why before anything changes. Either way, we handle the setup so you do not have to figure it out alone.',
                'sort_order' => 2,
            ]
        );

        // Complexity fear
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Will this turn into a complicated system I never finish?',
            ],
            [
                'answer' => 'We keep it practical. One or two high-value automations that save real hours beat a sprawling setup nobody maintains. We start small, prove the value, then expand only what you will actually use.',
                'sort_order' => 3,
            ]
        );

        // Tech skill
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'I am not technical. Can I still use automations?',
            ],
            [
                'answer' => 'Yes. You should feel the benefit without living inside a workflow builder. We set things up, explain what happens in plain language, and leave you with a simple way to know when something needs attention.',
                'sort_order' => 4,
            ]
        );

        // Examples
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What are common automations for local small businesses?',
            ],
            [
                'answer' => 'Missed-call texts, review asks after a job, polite payment nudges, calendar handoffs, quiet check-ins to past customers, Friday "here is what came in" notes. Nobody loves doing those by hand. Automate them once, and the boring work keeps happening while you stay on the porch with real people.',
                'sort_order' => 5,
            ]
        );

        // Time to value
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How quickly will I feel the time savings?',
            ],
            [
                'answer' => 'Often within days of going live for a focused automation, like auto follow-ups or lead alerts. Bigger chains take longer to design carefully. We prioritize the bottlenecks that steal your evenings first.',
                'sort_order' => 6,
            ]
        );

        // Maintenance
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What happens if an automation breaks later?',
            ],
            [
                'answer' => 'Tools change, and connections can need a tune-up. We build with monitoring where it matters and can stay available for support. You will know who to call instead of discovering a silent failure weeks later.',
                'sort_order' => 7,
            ]
        );

        // AI in automations
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do your automations use AI?',
            ],
            [
                'answer' => 'When it helps. Some workflows are simple rules: if this, then that. Others benefit from AI, like summarizing notes, drafting a first reply you still approve, or sorting inquiries by urgency. We only add AI where it saves real time and stays under your control, not because it sounds trendy.',
                'sort_order' => 8,
            ]
        );
    }
}
