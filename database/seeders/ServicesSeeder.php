<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Seed the five services offered on the marketing site.
     *
     * Events are disabled so stable public slugs (including cases where
     * Str::slug(title) would differ) can be set explicitly.
     */
    public function run(): void
    {
        Service::withoutEvents(function (): void {
            // Lead Generation
            Service::updateOrCreate(
                ['slug' => 'lead-generation'],
                [
                    'title' => 'Lead generation',
                    'description' => 'Reach the right people with a clear reason to reach out, not another ignored ad.',
                    'sort_order' => 1,
                ]
            );

            // Email Marketing
            Service::updateOrCreate(
                ['slug' => 'email-marketing'],
                [
                    'title' => 'Email marketing',
                    'description' => 'Stay in touch in a personal way so customers remember you and come back.',
                    'sort_order' => 2,
                ]
            );

            // Website Design & Development
            Service::updateOrCreate(
                ['slug' => 'website-design-and-development'],
                [
                    'title' => 'Website design & development',
                    'description' => 'A site that looks good, loads fast on phones, and makes the next step easy.',
                    'sort_order' => 3,
                ]
            );

            // Business Automations
            Service::updateOrCreate(
                ['slug' => 'business-automations'],
                [
                    'title' => 'Business automations',
                    'description' => 'Let the repetitive stuff run itself so you can focus on customers.',
                    'sort_order' => 4,
                ]
            );

            // Custom Software Development
            Service::updateOrCreate(
                ['slug' => 'custom-software-development'],
                [
                    'title' => 'Custom software development',
                    'description' => 'When ready-made tools do not fit, we build something that does.',
                    'sort_order' => 5,
                ]
            );
        });

        $this->call([
            FaqLeadGenerationSeeder::class,
            FaqEmailMarketingSeeder::class,
            FaqWebsiteDesignAndDevelopmentSeeder::class,
            FaqBusinessAutomationsSeeder::class,
            FaqCustomSoftwareDevelopmentSeeder::class,
        ]);
    }
}
