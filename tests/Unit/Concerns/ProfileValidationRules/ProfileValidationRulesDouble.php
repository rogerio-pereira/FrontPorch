<?php

namespace Tests\Unit\Concerns\ProfileValidationRules;

use App\Concerns\ProfileValidationRules;

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
    public function exposeEmailRules(?string $userId = null): array
    {
        return $this->emailRules($userId);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function exposeProfileRules(?string $userId = null): array
    {
        return $this->profileRules($userId);
    }
}
