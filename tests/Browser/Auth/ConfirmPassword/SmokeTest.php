<?php

use App\Models\User;

it('smoke tests the confirm password page for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/user/confirm-password')
        ->waitForEvent('networkidle')
        ->assertSee('Confirm password')
        ->assertPresent('@confirm-password-button');
});

it('redirects guests from confirm password to login', function () {
    visit('/user/confirm-password')
        ->assertPathIs('/login');
});
