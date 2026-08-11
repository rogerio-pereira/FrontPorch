<?php

use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

it('configures strict password defaults in production', function () {
    $this->app->instance('env', 'production');

    $provider = new AppServiceProvider($this->app);
    $method = new ReflectionMethod($provider, 'configureDefaults');
    $method->invoke($provider);

    $validator = Validator::make(
        ['password' => 'password'],
        ['password' => ['required', Password::default()]],
    );

    expect($validator->fails())->toBeTrue();
});
