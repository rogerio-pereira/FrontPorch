<?php

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tests\Unit\Concerns\ProfileValidationRules\ProfileValidationRulesDouble;

it('email must be unique when user id is null', function () {
    $existingUser = User::factory()->create();

    $validator = Validator::make(
        ['email' => $existingUser->email],
        ['email' => (new ProfileValidationRulesDouble)->exposeEmailRules()],
    );

    expect($validator->fails())->toBeTrue();
});
