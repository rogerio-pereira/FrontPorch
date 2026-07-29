<?php

use App\Models\Service;
use App\Models\User;

it('shows the admin indexes to authenticated users', function (string $url, string $heading) {
    $this->actingAs(User::factory()->create());

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($heading);
})->with([
    ['/core/services', 'Services'],
]);

it('shows the admin create forms to authenticated users', function (string $url, string $heading, string $submit) {
    $this->actingAs(User::factory()->create());

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($heading)
        ->assertPresent($submit);
})->with([
    ['/core/services/create', 'New service', '@service-submit'],
]);

it('shows the admin edit forms to authenticated users', function () {
    $this->actingAs(User::factory()->create());

    $service = Service::factory()->create(['title' => 'Lead generation']);

    visit('/core/services/'.$service->id.'/edit')
        ->waitForEvent('networkidle')
        ->assertSee('Edit service')
        ->assertPresent('@service-submit');
});
