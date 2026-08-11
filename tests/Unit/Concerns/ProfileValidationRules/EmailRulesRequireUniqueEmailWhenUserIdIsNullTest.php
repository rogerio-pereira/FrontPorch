<?php

use Illuminate\Validation\Rules\Unique;
use Tests\Unit\Concerns\ProfileValidationRules\ProfileValidationRulesDouble;

it('email rules require unique email when user id is null', function () {
    $rules = (new ProfileValidationRulesDouble)->exposeEmailRules();

    expect($rules)->toContain('required');
    expect($rules)->toContain('email');

    $uniqueRule = collect($rules)->first(
        fn (mixed $rule): bool => $rule instanceof Unique,
    );

    expect($uniqueRule)->toBeInstanceOf(Unique::class);
});
