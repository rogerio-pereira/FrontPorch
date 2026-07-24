<?php

use App\Models\User;
use Laravel\Fortify\Features;

it('password cannot be reset with invalid token', function () {
    $this->skipUnlessFortifyHas(Features::resetPasswords());

    $user = User::factory()->create();

    $response = $this->post(route('password.update'), [
        'token' => 'invalid-token',
        'email' => $user->email,
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertSessionHasErrors('email');
});
