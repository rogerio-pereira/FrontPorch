<?php

use App\Models\Service;
use App\Models\User;

it('shows the services admin screens to authenticated users', function (string $url, string $heading, ?string $submit) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $page = visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($heading);

    if ($submit !== null) {
        $page->assertPresent($submit);
    }
})->with([
    'index' => ['/core/services', 'Services', null],
    'create' => ['/core/services/create', 'New service', '@service-submit'],
]);

it('shows the services edit form to authenticated users', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    $url = "/core/services/{$service->id}/edit";

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee('Edit service')
        ->assertPresent('@service-submit');
});

it('creates a service from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    visit('/core/services/create')
        ->waitForEvent('networkidle')
        ->type('title', 'Business automations')
        ->type('description', 'Let the repetitive stuff run itself.')
        ->type('sort_order', '4')
        ->click('@service-submit')
        ->waitForText('Business automations')
        ->assertPathIs('/core/services');

    $serviceExists = Service::where('slug', 'business-automations')
                        ->exists();

    expect($serviceExists)
        ->toBeTrue();
});

it('edits a service from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                        'description' => 'Find more of the right people.',
                        'sort_order' => 1,
                    ]);

    visit("/core/services/{$service->id}/edit")
        ->waitForEvent('networkidle')
        ->type('title', 'Lead generation refreshed')
        ->click('@service-submit')
        ->waitForText('Lead generation refreshed')
        ->assertPathIs('/core/services');

    $slug = $service->refresh()
                ->slug;

    expect($slug)->toBe('lead-generation-refreshed');
});

it('deletes a service from the admin index', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $service = Service::factory()
                    ->create([
                        'title' => 'Delete this service',
                    ]);

    visit('/core/services')
        ->waitForEvent('networkidle')
        ->assertSee('Delete this service')
        ->click("@service-delete-{$service->id}")
        ->waitForText('No services yet.')
        ->assertDontSee('Delete this service');

    $deleted = Service::find($service->id);

    expect($deleted)->toBeNull();
});
