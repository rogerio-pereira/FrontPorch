<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->admin = User::factory()->create();

    $this->actingAs($this->admin);
});

it('lists the users', function () {
    $this->get('/core/users')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/users/Index')
            ->has('users', 1)
            ->has('users.0', fn (Assert $user) => $user
                ->where('id', $this->admin->id)
                ->where('name', $this->admin->name)
                ->where('email', $this->admin->email)
            )
        );
});

it('shows the form to create a user', function () {
    $this->get('/core/users/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/users/Form')
            ->where('user', null)
        );
});

it('creates a user with a hashed password', function () {
    $this->post('/core/users', [
        'name' => 'Amelia Porch',
        'email' => 'amelia@example.com',
        'password' => 'front-porch-secret',
        'password_confirmation' => 'front-porch-secret',
    ])->assertRedirect('/core/users');

    $user = User::where('email', 'amelia@example.com')->firstOrFail();

    expect($user->name)->toBe('Amelia Porch');
    expect(Hash::check('front-porch-secret', $user->password))->toBeTrue();
});

it('validates the user payload', function () {
    $this->post('/core/users', [
        'name' => '',
        'email' => 'not-an-email',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ])->assertSessionHasErrors(['name', 'email', 'password']);
});

it('shows the form to edit a user', function () {
    $this->get("/core/users/{$this->admin->id}/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/users/Form')
            ->has('user', fn (Assert $user) => $user
                ->where('id', $this->admin->id)
                ->where('name', $this->admin->name)
                ->where('email', $this->admin->email)
            )
        );
});

it('updates a user without changing the password', function () {
    $user = User::factory()->create();
    $password = $user->password;

    $this->put("/core/users/{$user->id}", [
        'name' => 'Renamed Person',
        'email' => 'renamed@example.com',
        'password' => '',
    ])->assertRedirect('/core/users');

    $user->refresh();

    expect($user->name)->toBe('Renamed Person');
    expect($user->email)->toBe('renamed@example.com');
    expect($user->password)->toBe($password);
});

it('updates the password of a user when one is provided', function () {
    $user = User::factory()->create();

    $this->put("/core/users/{$user->id}", [
        'name' => $user->name,
        'email' => $user->email,
        'password' => 'another-long-secret',
        'password_confirmation' => 'another-long-secret',
    ])->assertRedirect('/core/users');

    expect(Hash::check('another-long-secret', $user->refresh()->password))->toBeTrue();
});

it('deletes another user', function () {
    $user = User::factory()->create();

    $this->delete("/core/users/{$user->id}")->assertRedirect('/core/users');

    expect(User::find($user->id))->toBeNull();
});

it('refuses to delete the signed-in user', function () {
    $this->delete("/core/users/{$this->admin->id}")->assertRedirect('/core/users');

    expect(User::find($this->admin->id))->not->toBeNull();
});

it('has no detail page for users', function () {
    $this->get("/core/users/{$this->admin->id}")->assertNotFound();
});
