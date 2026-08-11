<?php

use App\Models\User;
use Illuminate\Validation\Rules\Unique;
use Tests\Unit\Concerns\ProfileValidationRules\ProfileValidationRulesDouble;

it('email rules ignore current user when user id is provided', function () {
    $user = User::factory()->create();

    $rules = (new ProfileValidationRulesDouble)->exposeEmailRules($user->id);

    $uniqueRule = collect($rules)->first(
        fn (mixed $rule): bool => $rule instanceof Unique,
    );

    expect($uniqueRule)->toBeInstanceOf(Unique::class);
});
