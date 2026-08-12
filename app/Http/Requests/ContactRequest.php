<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'services' => ['nullable', 'array', 'max:20'],
            'services.*' => [
                'string',
                'distinct',
                Rule::exists('services', 'slug')->whereNull('deleted_at'),
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
            'cf-turnstile-response.required' => 'Please complete the security check.',
        ];
    }
}
