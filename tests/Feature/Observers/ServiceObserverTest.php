<?php

use App\Models\Service;

it('derives the slug from the title on create', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Website Design & Development',
                    ]);

    $slug = $service->slug;

    expect($slug)->toBe('website-design-development');
});

it('keeps the slug when the title is unchanged', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Business Automations',
                    ]);

    $service->update([
        'description' => 'A refreshed blurb for the home page.',
    ]);

    $slug = $service->slug;

    expect($slug)->toBe('business-automations');
});

it('regenerates the slug when the title changes', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead Generation',
                    ]);

    $service->update([
        'title' => 'Email Marketing',
    ]);

    $slug = $service->slug;

    expect($slug)->toBe('email-marketing');
});

it('rejects a title that cannot produce a slug', function () {
    Service::factory()
        ->create([
            'title' => '###',
        ]);
})->throws(InvalidArgumentException::class);
