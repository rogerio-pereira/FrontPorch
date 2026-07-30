<?php

use App\Models\Service;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);
});

it('lists the services in display order', function () {
    Service::factory()
        ->create([
            'title' => 'Email marketing',
            'sort_order' => 2,
        ]);

    Service::factory()
        ->create([
            'title' => 'Lead generation',
            'sort_order' => 1,
        ]);

    $response = $this->get('/core/services');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/services/Index')
        ->has('services', 2)
        ->has('services.0', fn (Assert $service) => $service
            ->where('title', 'Lead generation')
            ->where('slug', 'lead-generation')
            ->where('sort_order', 1)
            ->has('id')
            ->has('description')
        )
    );
});

it('shows the form to create a service', function () {
    $response = $this->get('/core/services/create');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/services/Form')
        ->where('service', null)
    );
});

it('creates a service and derives its slug', function () {
    $response = $this->post(
        '/core/services',
        [
            'title' => 'Business automations',
            'description' => 'Let the repetitive stuff run itself.',
            'sort_order' => 4,
        ]
    );

    $response->assertRedirect('/core/services');

    $service = Service::where('title', 'Business automations')
                    ->firstOrFail();

    $slug = $service->slug;
    expect($slug)->toBe('business-automations');

    $sortOrder = $service->sort_order;
    expect($sortOrder)->toBe(4);
});

it('validates the service payload', function () {
    $response = $this->post(
        '/core/services',
        [
            'title' => '',
            'description' => '',
            'sort_order' => 'first',
        ]
    );

    $response->assertSessionHasErrors([
        'title',
        'description',
        'sort_order',
    ]);
});

it('rejects a duplicate title', function () {
    Service::factory()
        ->create(['title' => 'Lead generation']);

    $response = $this->post(
        '/core/services',
        [
            'title' => 'Lead generation',
            'description' => 'Duplicate title should fail.',
            'sort_order' => 2,
        ]
    );

    $response->assertSessionHasErrors(['title']);
});

it('allows updating a service without changing its title', function () {
    $service = Service::factory()
                    ->create(['title' => 'Lead generation']);

    $response = $this->put(
        "/core/services/{$service->id}",
        [
            'title' => 'Lead generation',
            'description' => 'Updated description only.',
            'sort_order' => 3,
        ]
    );

    $response->assertRedirect('/core/services');

    $service->refresh();

    $slug = $service->slug;
    expect($slug)->toBe('lead-generation');

    $description = $service->description;
    expect($description)->toBe('Updated description only.');

    $sortOrder = $service->sort_order;
    expect($sortOrder)->toBe(3);
});

it('shows the form to edit a service', function () {
    $service = Service::factory()
                    ->create(['title' => 'Lead generation']);

    $url = "/core/services/{$service->id}/edit";
    $response = $this->get($url);

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/services/Form')
        ->has('service', fn (Assert $props) => $props
            ->where('id', $service->id)
            ->where('title', 'Lead generation')
            ->where('slug', 'lead-generation')
            ->has('description')
            ->has('sort_order')
        )
    );
});

it('updates a service and regenerates the slug', function () {
    $service = Service::factory()
                    ->create(['title' => 'Lead generation']);

    $response = $this->put(
        "/core/services/{$service->id}",
        [
            'title' => 'Lead generation and follow-up',
            'description' => 'Reach the right people and answer them quickly.',
            'sort_order' => 2,
        ]
    );

    $response->assertRedirect('/core/services');

    $service->refresh();

    $slug = $service->slug;
    expect($slug)->toBe('lead-generation-and-follow-up');

    $sortOrder = $service->sort_order;
    expect($sortOrder)->toBe(2);
});

it('soft deletes a service', function () {
    $service = Service::factory()
                    ->create();

    $url = "/core/services/{$service->id}";
    $response = $this->delete($url);

    $response->assertRedirect('/core/services');

    $deleted = Service::find($service->id);
    $trashed = Service::withTrashed()
                    ->find($service->id);

    expect($deleted)->toBeNull();
    expect($trashed)->not->toBeNull();
});

it('has no detail page for services', function () {
    $service = Service::factory()
                    ->create();

    $url = "/core/services/{$service->id}";
    $response = $this->get($url);

    $response->assertNotFound();
});
