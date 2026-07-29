<?php

use App\Models\Service;
use App\Models\User;

it('creates a service from the admin form', function () {
    $this->actingAs(User::factory()->create());

    visit('/core/services/create')
        ->waitForEvent('networkidle')
        ->type('title', 'Business automations')
        ->type('description', 'Let the repetitive stuff run itself.')
        ->type('sort_order', '4')
        ->click('@service-submit')
        ->waitForText('Business automations')
        ->assertPathIs('/core/services');

    expect(Service::where('slug', 'business-automations')->exists())->toBeTrue();
});

it('edits a service from the admin form', function () {
    $this->actingAs(User::factory()->create());

    $service = Service::factory()->create([
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

    expect($service->refresh()->slug)->toBe('lead-generation-refreshed');
});

it('deletes a service from the admin index', function () {
    $this->actingAs(User::factory()->create());

    $service = Service::factory()->create(['title' => 'Delete this service']);

    visit('/core/services')
        ->waitForEvent('networkidle')
        ->assertSee('Delete this service')
        ->click("@service-delete-{$service->id}")
        ->waitForText('No services yet.')
        ->assertDontSee('Delete this service');

    expect(Service::find($service->id))->toBeNull();
});
