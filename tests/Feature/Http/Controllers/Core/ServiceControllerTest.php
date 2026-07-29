<?php

use App\Models\Service;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('lists the services in display order', function () {
    Service::factory()->ordered(2)->create(['title' => 'Email marketing']);
    Service::factory()->ordered(1)->create(['title' => 'Lead generation']);

    $this->get('/core/services')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
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
    $this->get('/core/services/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/services/Form')
            ->where('service', null)
        );
});

it('creates a service and derives its slug', function () {
    $this->post('/core/services', [
        'title' => 'Business automations',
        'description' => 'Let the repetitive stuff run itself.',
        'sort_order' => 4,
    ])->assertRedirect('/core/services');

    $service = Service::where('title', 'Business automations')->firstOrFail();

    expect($service->slug)->toBe('business-automations');
    expect($service->sort_order)->toBe(4);
});

it('validates the service payload', function () {
    $this->post('/core/services', [
        'title' => '',
        'description' => '',
        'sort_order' => 'first',
    ])->assertSessionHasErrors(['title', 'description', 'sort_order']);
});

it('shows the form to edit a service', function () {
    $service = Service::factory()->create(['title' => 'Lead generation']);

    $this->get("/core/services/{$service->id}/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
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
    $service = Service::factory()->create(['title' => 'Lead generation']);

    $this->put("/core/services/{$service->id}", [
        'title' => 'Lead generation and follow-up',
        'description' => 'Reach the right people and answer them quickly.',
        'sort_order' => 2,
    ])->assertRedirect('/core/services');

    $service->refresh();

    expect($service->slug)->toBe('lead-generation-and-follow-up');
    expect($service->sort_order)->toBe(2);
});

it('soft deletes a service', function () {
    $service = Service::factory()->create();

    $this->delete("/core/services/{$service->id}")->assertRedirect('/core/services');

    expect(Service::find($service->id))->toBeNull();
    expect(Service::withTrashed()->find($service->id))->not->toBeNull();
});

it('has no detail page for services', function () {
    $service = Service::factory()->create();

    $this->get("/core/services/{$service->id}")->assertNotFound();
});
