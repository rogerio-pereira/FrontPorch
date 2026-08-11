<?php

use App\Models\User;

it('profile page is displayed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk();
});
