<?php

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('lists the testimonials with their service', function () {
    $service = Service::factory()->create(['title' => 'Email marketing']);

    $testimonial = Testimonial::factory()->forService($service)->create([
        'person' => 'Owner, Lakeland boutique',
        'testimonial' => 'Our monthly email brings people back into the shop.',
    ]);

    $this->get('/core/testimonials')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/testimonials/Index')
            ->has('testimonials', 1)
            ->has('testimonials.0', fn (Assert $props) => $props
                ->where('id', $testimonial->id)
                ->where('person', 'Owner, Lakeland boutique')
                ->where('testimonial', 'Our monthly email brings people back into the shop.')
                ->where('service', 'Email marketing')
                ->where('service_id', $service->id)
            )
        );
});

it('shows the form to create a testimonial', function () {
    Service::factory()->create();

    $this->get('/core/testimonials/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/testimonials/Form')
            ->where('testimonial', null)
            ->has('services', 1)
        );
});

it('creates a testimonial', function () {
    $service = Service::factory()->create();

    $this->post('/core/testimonials', [
        'person' => 'Owner, Tampa roofing crew',
        'testimonial' => 'Our old site looked terrible on a phone. That is fixed now.',
        'service_id' => $service->id,
    ])->assertRedirect('/core/testimonials');

    expect(Testimonial::where('person', 'Owner, Tampa roofing crew')->firstOrFail()->service_id)->toBe($service->id);
});

it('requires a service on a testimonial', function () {
    $this->post('/core/testimonials', [
        'person' => '',
        'testimonial' => '',
    ])->assertSessionHasErrors(['person', 'testimonial', 'service_id']);
});

it('shows the form to edit a testimonial', function () {
    $testimonial = Testimonial::factory()->create(['person' => 'Owner, Plant City feed store']);

    $this->get("/core/testimonials/{$testimonial->id}/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/testimonials/Form')
            ->has('testimonial', fn (Assert $props) => $props
                ->where('id', $testimonial->id)
                ->where('person', 'Owner, Plant City feed store')
                ->etc()
            )
        );
});

it('updates a testimonial', function () {
    $testimonial = Testimonial::factory()->create();
    $service = Service::factory()->create();

    $this->put("/core/testimonials/{$testimonial->id}", [
        'person' => 'Office lead, Sarasota HVAC company',
        'testimonial' => 'We stopped re-typing the same customer details.',
        'service_id' => $service->id,
    ])->assertRedirect('/core/testimonials');

    $testimonial->refresh();

    expect($testimonial->person)->toBe('Office lead, Sarasota HVAC company');
    expect($testimonial->service_id)->toBe($service->id);
});

it('soft deletes a testimonial', function () {
    $testimonial = Testimonial::factory()->create();

    $this->delete("/core/testimonials/{$testimonial->id}")->assertRedirect('/core/testimonials');

    expect(Testimonial::find($testimonial->id))->toBeNull();
    expect(Testimonial::withTrashed()->find($testimonial->id))->not->toBeNull();
});

it('has no detail page for testimonials', function () {
    $testimonial = Testimonial::factory()->create();

    $this->get("/core/testimonials/{$testimonial->id}")->assertNotFound();
});
