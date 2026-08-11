<?php

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tests\Unit\Concerns\ProfileValidationRules\ProfileValidationRulesDouble;

it('email may match current user when user id is provided', function () {
    $user = User::factory()->create();

    $validator = Validator::make(
        ['email' => $user->email],
        ['email' => (new ProfileValidationRulesDouble)->exposeEmailRules($user->id)],
    );

    expect($validator->fails())->toBeFalse();
});
