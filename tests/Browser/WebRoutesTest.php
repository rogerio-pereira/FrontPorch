<?php

use App\Models\User;

it('smoke tests public web routes', function () {
    visit('/')
        ->assertSee('Log in');

    visit('/login')
        ->assertSee('Email address')
        ->assertPresent('@login-button');

    visit('/dashboard')
        ->assertPathIs('/login');
});

it('smoke tests authenticated dashboard route', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/dashboard')
        ->waitForEvent('networkidle')
        ->assertSee('Dashboard');
});
