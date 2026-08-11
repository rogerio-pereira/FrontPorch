<?php

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;

beforeEach()->flaky();

it('shows the testimonials admin screens to authenticated users', function (string $url, string $heading, ?string $submit) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    Service::factory()
        ->create([
            'title' => 'Lead generation',
        ]);

    $page = visit($url)
                ->waitForEvent('networkidle')
                ->assertSee($heading);

    if ($submit !== null) {
        $page->assertPresent($submit);
    }
})->with([
    'index' => ['/core/testimonials', 'Testimonials', null],
    'create' => ['/core/testimonials/create', 'New testimonial', '@testimonial-submit'],
]);

it('shows the testimonials edit form to authenticated users', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    $testimonial = Testimonial::factory()
                        ->create([
                            'service_id' => $service->id,
                            'person' => 'Jordan Client',
                        ]);

    $url = "/core/testimonials/{$testimonial->id}/edit";

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee('Edit testimonial')
        ->assertPresent('@testimonial-submit');
});

it('creates a testimonial from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    visit('/core/testimonials/create')
        ->waitForEvent('networkidle')
        ->type('person', 'Jordan Client')
        ->type('testimonial', 'They made our front porch feel welcoming online.')
        ->select('service_id', $service->id)
        ->click('@testimonial-submit')
        ->waitForText('Jordan Client')
        ->assertPathIs('/core/testimonials');

    $testimonialExists = Testimonial::where('person', 'Jordan Client')
                        ->exists();

    expect($testimonialExists)
        ->toBeTrue();
});

it('edits a testimonial from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    $testimonial = Testimonial::factory()
                        ->create([
                            'service_id' => $service->id,
                            'person' => 'Original Person',
                            'testimonial' => 'Original quote.',
                        ]);

    visit("/core/testimonials/{$testimonial->id}/edit")
        ->waitForEvent('networkidle')
        ->type('person', 'Updated Person')
        ->click('@testimonial-submit')
        ->waitForText('Updated Person')
        ->assertPathIs('/core/testimonials');

    $person = $testimonial->refresh()
                    ->person;

    expect($person)->toBe('Updated Person');
});

it('deletes a testimonial from the admin index', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $service = Service::factory()
                    ->create();

    $testimonial = Testimonial::factory()
                        ->create([
                            'service_id' => $service->id,
                            'person' => 'Delete This Person',
                        ]);

    visit('/core/testimonials')
        ->waitForEvent('networkidle')
        ->assertSee('Delete This Person')
        ->click("@testimonial-delete-{$testimonial->id}")
        ->waitForText('No testimonials yet.')
        ->assertDontSee('Delete This Person');

    $deleted = Testimonial::find($testimonial->id);

    expect($deleted)->toBeNull();
});
