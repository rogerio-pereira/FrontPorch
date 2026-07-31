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
                'answer' => 'Anything repetitive that a system can run so you do not have to babysit it. That can be as simple as an auto-reply when someone fills a form, a reminder before an appointment, or moving a new lead into a spreadsheet or CRM. It can also be more involved: chaining several tools together, syncing data between apps, routing work to the right person, or kicking off multi-step follow-ups. And it goes beyond day-to-day sales tasks, things like scheduled backups, report summaries, inventory alerts, or nightly cleanups that keep the business humming while you sleep. The goal is less copy-paste, fewer dropped balls, and more time with customers.',
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
                'answer' => 'Not always. Sometimes the apps you already have are enough; sometimes a small external tool or integrator is the cleanest way to connect them. Either path still needs real setup: mapping how work should flow, building the workflows, and testing handoffs so nothing falls through. We handle that side for you. If a new tool would help, we explain the cost (some tools are free) and why before anything changes.',
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
    }
}
