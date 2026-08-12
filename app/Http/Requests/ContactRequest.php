<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use RyanChandler\LaravelCloudflareTurnstile\Rules\Turnstile;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => [
                'nullable',
                'string',
                'max:14',
                // US phone only: (813) 555-0100
                'regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            ],
            'website' => ['nullable', 'url', 'max:255'],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => [
                'string',
                'distinct',
                'exists:services,title',
            ],
            'cf-turnstile-response' => ['required', new Turnstile],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid US phone number as (555) 555-5555.',
            'services.required' => 'Please select at least one service.',
            'services.min' => 'Please select at least one service.',
            'cf-turnstile-response.required' => 'Please complete the security check.',
        ];
    }
}
