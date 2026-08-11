<?php

namespace App\Concerns;

trait ImageValidationRules
{
    /**
     * Get the validation rules shared by every uploaded image.
     *
     * @return list<string>
     */
    protected function imageFileRules(): array
    {
        return ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'];
    }
}
