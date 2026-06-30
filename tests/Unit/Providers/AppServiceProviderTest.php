<?php

namespace Tests\Unit\Providers;

use App\Providers\AppServiceProvider;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use ReflectionMethod;
use Tests\TestCase;

class AppServiceProviderTest extends TestCase
{
    public function test_configures_carbon_immutable_as_default_date_class(): void
    {
        $this->invokeConfigureDefaults('testing');

        $this->assertInstanceOf(CarbonImmutable::class, Date::now());
    }

    public function test_configures_strict_password_defaults_in_production(): void
    {
        $this->invokeConfigureDefaults('production');

        $validator = Validator::make(
            ['password' => 'password'],
            ['password' => ['required', Password::default()]],
        );

        $this->assertTrue($validator->fails());
    }

    public function test_uses_laravel_fallback_password_defaults_outside_production(): void
    {
        $this->invokeConfigureDefaults('testing');

        $password = Password::default();

        $this->assertTrue($password->passes('password', 'password'));
    }

    private function invokeConfigureDefaults(string $environment): void
    {
        $this->app->instance('env', $environment);

        $provider = new AppServiceProvider($this->app);

        $method = new ReflectionMethod($provider, 'configureDefaults');
        $method->invoke($provider);
    }
}
