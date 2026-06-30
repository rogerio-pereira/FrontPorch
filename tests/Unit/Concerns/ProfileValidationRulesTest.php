<?php

namespace Tests\Unit\Concerns;

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;
use Tests\TestCase;

class ProfileValidationRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_rules_require_a_string_up_to_255_characters(): void
    {
        $rules = $this->rulesDouble()->exposeNameRules();

        $this->assertSame(['required', 'string', 'max:255'], $rules);
    }

    public function test_email_rules_require_unique_email_when_user_id_is_null(): void
    {
        $rules = $this->rulesDouble()->exposeEmailRules();

        $this->assertContains('required', $rules);
        $this->assertContains('email', $rules);

        $uniqueRule = collect($rules)->first(
            fn (mixed $rule): bool => $rule instanceof Unique,
        );

        $this->assertInstanceOf(Unique::class, $uniqueRule);
    }

    public function test_email_rules_ignore_current_user_when_user_id_is_provided(): void
    {
        $user = User::factory()->create();

        $rules = $this->rulesDouble()->exposeEmailRules($user->id);

        $uniqueRule = collect($rules)->first(
            fn (mixed $rule): bool => $rule instanceof Unique,
        );

        $this->assertInstanceOf(Unique::class, $uniqueRule);
    }

    public function test_profile_rules_include_name_and_email_rules(): void
    {
        $rules = $this->rulesDouble()->exposeProfileRules();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('email', $rules);
    }

    public function test_email_must_be_unique_when_user_id_is_null(): void
    {
        $existingUser = User::factory()->create();

        $validator = Validator::make(
            ['email' => $existingUser->email],
            ['email' => $this->rulesDouble()->exposeEmailRules()],
        );

        $this->assertTrue($validator->fails());
    }

    public function test_email_may_match_current_user_when_user_id_is_provided(): void
    {
        $user = User::factory()->create();

        $validator = Validator::make(
            ['email' => $user->email],
            ['email' => $this->rulesDouble()->exposeEmailRules($user->id)],
        );

        $this->assertFalse($validator->fails());
    }

    private function rulesDouble(): ProfileValidationRulesDouble
    {
        return new ProfileValidationRulesDouble;
    }
}

class ProfileValidationRulesDouble
{
    use ProfileValidationRules;

    /**
     * @return array<int, mixed>
     */
    public function exposeNameRules(): array
    {
        return $this->nameRules();
    }

    /**
     * @return array<int, mixed>
     */
    public function exposeEmailRules(?int $userId = null): array
    {
        return $this->emailRules($userId);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function exposeProfileRules(?int $userId = null): array
    {
        return $this->profileRules($userId);
    }
}
