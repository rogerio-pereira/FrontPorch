<?php

use App\Models\User;

it('smoke tests the appearance settings page for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/settings/appearance')
        ->waitForEvent('networkidle')
        ->assertSee('Update the appearance settings for your account')
        ->assertPresent('@appearance-light')
        ->assertPresent('@appearance-dark')
        ->assertPresent('@appearance-system');
});

it('redirects guests from appearance settings to login', function () {
    visit('/settings/appearance')
        ->assertPathIs('/login');
});
