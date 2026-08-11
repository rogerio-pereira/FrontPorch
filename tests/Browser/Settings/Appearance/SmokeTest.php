<?php

use App\Models\User;

beforeEach()->flaky();

it('smoke tests the appearance settings page for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/settings/appearance')
        ->waitForEvent('networkidle')
        ->assertSee('The admin panel uses the Front Porch dark brand theme')
        ->assertPresent('@appearance-dark-only')
        ->assertMissing('@appearance-light')
        ->assertMissing('@appearance-dark')
        ->assertMissing('@appearance-system');
});

it('redirects guests from appearance settings to login', function () {
    visit('/settings/appearance')
        ->assertPathIs('/login');
});
