<?php

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;

it('creates a testimonial from the admin form', function () {
    $this->actingAs(User::factory()->create());

    $service = Service::factory()->create(['title' => 'Lead generation']);

    visit('/core/testimonials/create')
        ->waitForEvent('networkidle')
        ->type('person', 'Jordan Client')
        ->type('testimonial', 'They made our front porch feel welcoming online.')
        ->select('service_id', $service->id)
        ->click('@testimonial-submit')
        ->waitForText('Jordan Client')
        ->assertPathIs('/core/testimonials');

    expect(Testimonial::where('person', 'Jordan Client')->exists())->toBeTrue();
});

it('edits a testimonial from the admin form', function () {
    $this->actingAs(User::factory()->create());

    $service = Service::factory()->create(['title' => 'Lead generation']);
    $testimonial = Testimonial::factory()->forService($service)->create([
        'person' => 'Original Person',
        'testimonial' => 'Original quote.',
    ]);

    visit("/core/testimonials/{$testimonial->id}/edit")
        ->waitForEvent('networkidle')
        ->type('person', 'Updated Person')
        ->click('@testimonial-submit')
        ->waitForText('Updated Person')
        ->assertPathIs('/core/testimonials');

    expect($testimonial->refresh()->person)->toBe('Updated Person');
});

it('deletes a testimonial from the admin index', function () {
    $this->actingAs(User::factory()->create());

    $service = Service::factory()->create();
    $testimonial = Testimonial::factory()->forService($service)->create([
        'person' => 'Delete This Person',
    ]);

    visit('/core/testimonials')
        ->waitForEvent('networkidle')
        ->assertSee('Delete This Person')
        ->click("@testimonial-delete-{$testimonial->id}")
        ->waitForText('No testimonials yet.')
        ->assertDontSee('Delete This Person');

    expect(Testimonial::find($testimonial->id))->toBeNull();
});
