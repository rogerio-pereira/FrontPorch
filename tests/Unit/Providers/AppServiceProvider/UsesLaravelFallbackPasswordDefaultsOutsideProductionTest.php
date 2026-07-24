<?php

use App\Providers\AppServiceProvider;
use Illuminate\Validation\Rules\Password;

it('uses laravel fallback password defaults outside production', function () {
    $this->app->instance('env', 'testing');

    $provider = new AppServiceProvider($this->app);
    $method = new ReflectionMethod($provider, 'configureDefaults');
    $method->invoke($provider);

    expect(Password::default()->passes('password', 'password'))->toBeTrue();
});
