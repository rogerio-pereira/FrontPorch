<?php

use App\Models\User;
use Laravel\Fortify\Features;

it('redirects guests from the two factor challenge to login', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    visit('/two-factor-challenge')
        ->assertPathIs('/login');
});

it('shows the two factor challenge after login when enabled', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->withTwoFactor()->create();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('two-factor.login'));

    visit('/two-factor-challenge')
        ->waitForEvent('networkidle')
        ->assertPathIs('/two-factor-challenge')
        ->assertSee('Authentication code')
        ->assertPresent('@two-factor-continue-button');
});
