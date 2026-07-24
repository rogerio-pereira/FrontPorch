<?php

use App\Models\User;

it('smoke tests the profile settings page for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/settings/profile')
        ->waitForEvent('networkidle')
        ->assertSee('Update your name and email address')
        ->assertPresent('@update-profile-button')
        ->assertPresent('@delete-user-button');
});

it('redirects guests from profile settings to login', function () {
    visit('/settings/profile')
        ->assertPathIs('/login');
});
