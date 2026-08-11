<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;

it('reset password screen can be rendered', function () {
    $this->skipUnlessFortifyHas(Features::resetPasswords());

    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $this->get(route('password.reset', $notification->token))->assertOk();

        return true;
    });
});
