<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\UserStoreRequest;
use App\Http\Requests\Core\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * List the users who can sign in to the admin panel.
     */
    public function index(): Response
    {
        $users = [];

        foreach (User::orderBy('name')->get() as $user) {
            $users[] = $this->props($user);
        }

        return Inertia::render('core/users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form to create a user.
     */
    public function create(): Response
    {
        return Inertia::render('core/users/Form', [
            'user' => null,
        ]);
    }

    /**
     * Store a new user; the model hashes the password on save.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        User::create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('User created.')]);

        return to_route('core.users.index');
    }

    /**
     * Users are edited from the index; there is no detail page.
     */
    public function show(): never
    {
        abort(404);
    }

    /**
     * Show the form to edit a user.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('core/users/Form', [
            'user' => $this->props($user),
        ]);
    }

    /**
     * Update a user, keeping the current password when none is provided.
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $attributes = $request->validated();

        if (blank($request->validated('password'))) {
            unset($attributes['password']);
        }

        $user->update($attributes);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('User updated.')]);

        return to_route('core.users.index');
    }

    /**
     * Delete a user for good; users are not soft deleted.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $current = $request->user();

        if ($current !== null && $current->is($user)) {
            Inertia::flash('toast', ['type' => 'error', 'message' => __('You cannot delete the account you are signed in with.')]);

            return to_route('core.users.index');
        }

        $user->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('User deleted.')]);

        return to_route('core.users.index');
    }

    /**
     * Shape a user for the admin pages.
     *
     * @return array{id: string, name: string, email: string}
     */
    protected function props(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
