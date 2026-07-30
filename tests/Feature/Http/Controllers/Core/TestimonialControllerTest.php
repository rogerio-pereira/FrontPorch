<?php

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);
});

it('lists the testimonials with their service', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Email marketing',
                    ]);

    $testimonial = Testimonial::factory()
                    ->create([
                        'service_id' => $service->id,
                        'person' => 'Owner, Lakeland boutique',
                        'testimonial' => 'Our monthly email brings people back into the shop.',
                    ]);

    $response = $this->get('/core/testimonials');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/testimonials/Index')
        ->has('testimonials', 1)
        ->has('testimonials.0', fn (Assert $props) => $props
            ->where('id', $testimonial->id)
            ->where('person', 'Owner, Lakeland boutique')
            ->where('testimonial', 'Our monthly email brings people back into the shop.')
            ->where('service_id', $service->id)
            ->has('service', fn (Assert $attached) => $attached
                ->where('title', 'Email marketing')
                ->etc()
            )
            ->etc() // allows extra props (timestamps, etc.) without asserting each one.
        )
    );
});

it('shows the form to create a testimonial with the service options', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    $response = $this->get('/core/testimonials/create');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/testimonials/Form')
        ->where('testimonial', null)
        ->has('services', 1)
        ->where("services.{$service->id}", 'Lead generation')
    );
});

it('creates a testimonial', function () {
    $service = Service::factory()
                    ->create();

    $response = $this->post(
        '/core/testimonials',
        [
            'person' => 'Owner, Tampa roofing crew',
            'testimonial' => 'Our old site looked terrible on a phone. That is fixed now.',
            'service_id' => $service->id,
        ]
    );

    $response->assertRedirect('/core/testimonials');

    $testimonial = Testimonial::where('person', 'Owner, Tampa roofing crew')
                    ->firstOrFail();

    $serviceId = $testimonial->service_id;
    expect($serviceId)->toBe($service->id);
});

it('requires a service on a testimonial', function () {
    $response = $this->post(
        '/core/testimonials',
        [
            'person' => '',
            'testimonial' => '',
        ]
    );

    $response->assertSessionHasErrors([
        'person',
        'testimonial',
        'service_id',
    ]);
});

it('shows the form to edit a testimonial', function () {
    $testimonial = Testimonial::factory()
                    ->create([
                        'person' => 'Owner, Plant City feed store',
                    ]);

    $url = "/core/testimonials/{$testimonial->id}/edit";
    $response = $this->get($url);

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/testimonials/Form')
        ->has('testimonial', fn (Assert $props) => $props
            ->where('id', $testimonial->id)
            ->where('person', 'Owner, Plant City feed store')
            ->etc() // allows extra props (timestamps, etc.) without asserting each one.
        )
        ->has('services')
    );
});

it('updates a testimonial', function () {
    $testimonial = Testimonial::factory()
                    ->create();

    $service = Service::factory()
                    ->create();

    $response = $this->put(
        "/core/testimonials/{$testimonial->id}",
        [
            'person' => 'Office lead, Sarasota HVAC company',
            'testimonial' => 'We stopped re-typing the same customer details.',
            'service_id' => $service->id,
        ]
    );

    $response->assertRedirect('/core/testimonials');

    $testimonial->refresh();

    $person = $testimonial->person;
    expect($person)->toBe('Office lead, Sarasota HVAC company');

    $serviceId = $testimonial->service_id;
    expect($serviceId)->toBe($service->id);
});

it('soft deletes a testimonial', function () {
    $testimonial = Testimonial::factory()
                    ->create();

    $url = "/core/testimonials/{$testimonial->id}";
    $response = $this->delete($url);

    $response->assertRedirect('/core/testimonials');

    $deleted = Testimonial::find($testimonial->id);
    $trashed = Testimonial::withTrashed()
                    ->find($testimonial->id);

    expect($deleted)->toBeNull();
    expect($trashed)->not->toBeNull();
});

it('has no detail page for testimonials', function () {
    $testimonial = Testimonial::factory()
                    ->create();

    $url = "/core/testimonials/{$testimonial->id}";
    $response = $this->get($url);

    $response->assertNotFound();
});
