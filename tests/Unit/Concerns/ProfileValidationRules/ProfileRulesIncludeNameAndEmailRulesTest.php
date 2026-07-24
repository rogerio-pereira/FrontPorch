<?php

use Tests\Unit\Concerns\ProfileValidationRules\ProfileValidationRulesDouble;

it('profile rules include name and email rules', function () {
    $rules = (new ProfileValidationRulesDouble)->exposeProfileRules();

    expect($rules)->toHaveKey('name');
    expect($rules)->toHaveKey('email');
});
