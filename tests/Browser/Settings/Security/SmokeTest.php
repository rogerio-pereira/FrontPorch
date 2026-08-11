<?php

use App\Models\User;
use Laravel\Fortify\Features;

beforeEach()->flaky();

it('smoke tests the security settings page for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $this->withSession(['auth.password_confirmed_at' => time()]);

    visit('/settings/security')
        ->waitForEvent('networkidle')
        ->assertSee('Update password')
        ->assertPresent('@update-password-button');
});

it('asks authenticated users to confirm password before security settings', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/settings/security')
        ->waitForEvent('networkidle')
        ->assertPathIs('/user/confirm-password')
        ->assertPresent('@confirm-password-button');
});

it('redirects guests from security settings to login', function () {
    visit('/settings/security')
        ->assertPathIs('/login');
});
