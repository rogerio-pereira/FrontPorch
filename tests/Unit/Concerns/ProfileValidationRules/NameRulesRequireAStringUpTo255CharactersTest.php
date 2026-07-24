<?php

use Tests\Unit\Concerns\ProfileValidationRules\ProfileValidationRulesDouble;

it('name rules require a string up to 255 characters', function () {
    $rules = (new ProfileValidationRulesDouble)->exposeNameRules();

    expect($rules)->toBe(['required', 'string', 'max:255']);
});
