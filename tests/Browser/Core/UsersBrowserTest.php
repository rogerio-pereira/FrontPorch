<?php

use App\Models\User;

it('creates a user from the admin form', function () {
    $this->actingAs(User::factory()->create());

    visit('/core/users/create')
        ->waitForEvent('networkidle')
        ->type('name', 'Riley Admin')
        ->type('email', 'riley@example.com')
        ->type('password', 'front-porch-secret')
        ->type('password_confirmation', 'front-porch-secret')
        ->click('@user-submit')
        ->waitForText('Riley Admin')
        ->assertPathIs('/core/users');

    expect(User::where('email', 'riley@example.com')->exists())->toBeTrue();
});

it('edits a user from the admin form', function () {
    $this->actingAs(User::factory()->create());

    $user = User::factory()->create([
        'name' => 'Casey Editor',
        'email' => 'casey@example.com',
    ]);

    visit("/core/users/{$user->id}/edit")
        ->waitForEvent('networkidle')
        ->type('name', 'Casey Updated')
        ->click('@user-submit')
        ->waitForText('Casey Updated')
        ->assertPathIs('/core/users');

    expect($user->refresh()->name)->toBe('Casey Updated');
});

it('deletes a user from the admin index', function () {
    $this->actingAs(User::factory()->create());

    $user = User::factory()->create(['name' => 'Delete Me']);

    visit('/core/users')
        ->waitForEvent('networkidle')
        ->assertSee('Delete Me')
        ->click("@user-delete-{$user->id}")
        ->waitForEvent('networkidle')
        ->assertDontSee('Delete Me');

    expect(User::find($user->id))->toBeNull();
});
