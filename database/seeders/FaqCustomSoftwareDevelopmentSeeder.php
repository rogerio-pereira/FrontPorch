<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Database\Seeder;

class FaqCustomSoftwareDevelopmentSeeder extends Seeder
{
    /**
     * Seed the FAQs shown on the custom software development service landing.
     */
    public function run(): void
    {
        $service = Service::where('slug', 'custom-software-development')
            ->firstOrFail();

        // When custom
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'When does custom software make sense instead of off-the-shelf tools?',
            ],
            [
                'answer' => 'When ready-made apps fight your process: stretched spreadsheets, three tools that almost work, or workarounds stacked on workarounds. If a simpler product or automation can solve it, we will say so. Custom is for a better fit, not for complexity for its own sake.',
                'sort_order' => 1,
            ]
        );

        // Scope size
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do you only build large enterprise systems?',
            ],
            [
                'answer' => 'No. We build focused tools for small businesses: portals, internal dashboards, booking flows, inventory helpers, and similar pieces that match how you actually work, without enterprise bloat.',
                'sort_order' => 2,
            ]
        );

        // Process
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How do we start a custom software project?',
            ],
            [
                'answer' => 'With a discovery conversation about the problem, who uses the tool, and what success looks like. Then we outline a clear scope, phases if needed, and a written proposal. You always know what we are building before development begins.',
                'sort_order' => 3,
            ]
        );

        // Timeline cost
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Is custom software always expensive and slow?',
            ],
            [
                'answer' => 'It costs more than a template site, and thoughtful builds take time, but we scope tightly so you are not paying for features you will never use. A small, well-aimed tool often pays for itself by cutting hours of manual work.',
                'sort_order' => 4,
            ]
        );

        // Ownership
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Who owns the software when it is done?',
            ],
            [
                'answer' => 'You do, under the terms in our agreement. We are not locking you into a black box. We discuss hosting, access, and handoff so you stay in control of your business tool.',
                'sort_order' => 5,
            ]
        );

        // Changes later
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Can we change things after launch?',
            ],
            [
                'answer' => 'Yes. Real businesses evolve. We can plan phases from day one or support improvements later as you learn what your team needs. The first version should solve the core pain without pretending the world will never change.',
                'sort_order' => 6,
            ]
        );

        // Non-technical client
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'I am not a developer. How do we communicate during the build?',
            ],
            [
                'answer' => 'In plain language. We demystify progress with demos, clear milestones, and decisions framed around your workflow, not jargon. You should always understand what we are building and why.',
                'sort_order' => 7,
            ]
        );

        // Progress tracking
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How do I track progress?',
            ],
            [
                'answer' => 'Regular check-in meetings plus access to our Kanban board, so you can see what is in progress, what is next, and what is done without guessing. No mystery sprint theater, just a clear picture of the build.',
                'sort_order' => 8,
            ]
        );

        // Code ownership strategy
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Who controls the GitHub repo while we build?',
            ],
            [
                'answer' => 'We host it in a private GitHub repository under our control during development. Your project stays private, and we do not sell or shop it to competitors while we are building. We may keep a non-sensitive copy for our portfolio later. Trade secrets and confidential business details stay with you, always.',
                'sort_order' => 9,
            ]
        );

        // NDA
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Will you sign an NDA?',
            ],
            [
                'answer' => 'Yes, if you ask. We are happy to put confidentiality in writing before we dig into the details of your idea or operations.',
                'sort_order' => 10,
            ]
        );

        // Experience / trust
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What experience do you bring to custom software?',
            ],
            [
                'answer' => 'Our founders bring 15+ years of hands-on software work (coding since 2011), including software and APIs built end to end for clients across industries, and government projects. That means real production systems: architecture, coding, testing, security, deployment, and documentation, not weekend prototypes. We have learned what holds up in production and what falls apart.',
                'sort_order' => 11,
            ]
        );

        // Tech stack
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What technologies do you work with?',
            ],
            [
                'answer' => 'Our everyday stack is PHP (Laravel), Vue.js, and solid cloud hosting such as AWS or Laravel Cloud. We pick what fits your project, not whatever is trendy this month. The goal is a maintainable system your business can grow with.',
                'sort_order' => 12,
            ]
        );

        // Code quality
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'How do you ensure the code is solid?',
            ],
            [
                'answer' => 'Quality is part of the build, not a cleanup pass at the end. We write tests for critical paths, follow clear architecture, and avoid the quick fixes that become permanent headaches. You should get code another developer can understand later, not a private puzzle only we can open.',
                'sort_order' => 13,
            ]
        );

        // Security
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What about security?',
            ],
            [
                'answer' => 'Security is built in from the start: authentication, authorization, data validation, and protection against common attacks. Sensitive work gets treated like sensitive work. If your project has special requirements, we talk through them early instead of bolting something on after launch.',
                'sort_order' => 14,
            ]
        );

        // Delivery package
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What do I get when the project is done?',
            ],
            [
                'answer' => 'A working, production-ready application, plus the source code, documentation for setup and deployment, repository access, and the configuration needed to run and maintain it. Prefer it already live? We can hand over a deployed system, not just a zip file and a shrug.',
                'sort_order' => 15,
            ]
        );

        // Deployment
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Do you handle deployment and hosting setup?',
            ],
            [
                'answer' => 'Yes. We set up deployment pipelines and environments so updates are safer than "hope and FTP." Depending on what you want, the project can be ready for you to deploy, or already deployed and running.',
                'sort_order' => 16,
            ]
        );

        // Existing codebase
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'Can you work with software I already have?',
            ],
            [
                'answer' => 'Yes. We can extend or integrate with an existing codebase. Sometimes a legacy system is honestly faster to rebuild cleanly than to keep patching. We assess the situation and tell you which path is smarter, even when the answer is not the bigger invoice.',
                'sort_order' => 17,
            ]
        );

        // Bugs after launch
        Faq::updateOrCreate(
            [
                'service_id' => $service->id,
                'question' => 'What happens if bugs show up after launch?',
            ],
            [
                'answer' => 'We test before go-live and set up monitoring so problems surface early, not only when a customer complains. Critical bugs during an agreed warranty window are on us. After that, new changes or fixes are scoped as new work with clear pricing, no surprise hostage situation.',
                'sort_order' => 18,
            ]
        );
    }
}
