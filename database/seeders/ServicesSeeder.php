<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Seed the five services offered on the marketing site.
     */
    public function run(): void
    {
        foreach ($this->services() as $service) {
            $this->persist($service);
        }
    }

    /**
     * Create or refresh a single service, keeping its public slug stable.
     *
     * @param  array{slug: string, title: string, description: string, sort_order: int}  $attributes
     */
    protected function persist(array $attributes): void
    {
        $service = Service::where('slug', $attributes['slug'])
            ->first();

        $values = [
            'title' => $attributes['title'],
            'description' => $attributes['description'],
            'sort_order' => $attributes['sort_order'],
        ];

        if ($service === null) {
            $service = Service::create($values);
        } else {
            $service->update($values);
        }

        // The ServiceObserver derives the slug from the title, which does not
        // always match the slug the public routes and navigation rely on.
        if ($service->slug !== $attributes['slug']) {
            $service->forceFill([
                'slug' => $attributes['slug'],
            ]);

            $service->saveQuietly();
        }
    }

    /**
     * @return list<array{slug: string, title: string, description: string, sort_order: int}>
     */
    protected function services(): array
    {
        return [
            [
                'slug' => 'lead-generation',
                'title' => 'Lead generation',
                'description' => 'Reach the right people with a clear reason to reach out, not another ignored ad.',
                'sort_order' => 1,
            ],
            [
                'slug' => 'email-marketing',
                'title' => 'Email marketing',
                'description' => 'Stay in touch in a personal way so customers remember you and come back.',
                'sort_order' => 2,
            ],
            [
                'slug' => 'website-design-and-development',
                'title' => 'Website design & development',
                'description' => 'A site that looks good, loads fast on phones, and makes the next step easy.',
                'sort_order' => 3,
            ],
            [
                'slug' => 'business-automations',
                'title' => 'Business automations',
                'description' => 'Let the repetitive stuff run itself so you can focus on customers.',
                'sort_order' => 4,
            ],
            [
                'slug' => 'custom-software-development',
                'title' => 'Custom software development',
                'description' => 'When ready-made tools do not fit, we build something that does.',
                'sort_order' => 5,
            ],
        ];
    }
}
