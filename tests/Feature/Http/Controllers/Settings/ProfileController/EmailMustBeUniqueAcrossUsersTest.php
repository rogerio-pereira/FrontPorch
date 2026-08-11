<?php

use App\Models\User;

it('email must be unique across users', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from(route('profile.edit'))
        ->patch(route('profile.update'), [
            'name' => 'Test User',
            'email' => $otherUser->email,
        ]);

    $response
        ->assertSessionHasErrors('email')
        ->assertRedirect(route('profile.edit'));
});
