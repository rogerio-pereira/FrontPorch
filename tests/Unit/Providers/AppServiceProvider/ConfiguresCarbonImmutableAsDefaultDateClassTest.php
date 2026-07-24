<?php

use App\Providers\AppServiceProvider;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;

it('configures carbon immutable as default date class', function () {
    $this->app->instance('env', 'testing');

    $provider = new AppServiceProvider($this->app);
    $method = new ReflectionMethod($provider, 'configureDefaults');
    $method->invoke($provider);

    expect(Date::now())->toBeInstanceOf(CarbonImmutable::class);
});
