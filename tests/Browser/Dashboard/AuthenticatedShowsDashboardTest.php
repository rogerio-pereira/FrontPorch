<?php

use App\Models\User;

it('shows the dashboard for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/dashboard')
        ->waitForEvent('networkidle')
        ->assertSee('Dashboard');
});
