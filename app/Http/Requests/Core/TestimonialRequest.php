<?php

namespace App\Http\Requests\Core;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'person' => ['required', 'string', 'max:255'],
            'testimonial' => ['required', 'string'],
            'service_id' => ['required', 'uuid', 'exists:services,id'],
        ];
    }
}
