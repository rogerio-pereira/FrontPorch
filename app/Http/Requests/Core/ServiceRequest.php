<?php

namespace App\Http\Requests\Core;

use App\Models\Service;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class ServiceRequest extends FormRequest
{
    /**
     * Derive the public slug before validation so uniqueness can be checked.
     *
     * The ServiceObserver persists the same value; it is not mass-assignable.
     */
    protected function prepareForValidation(): void
    {
        $title = (string) $this->input('title', '');
        $slug = Str::slug($title);

        if ($slug === '') {
            $slug = 'item';
        }

        $this->merge([
            'slug' => $slug,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * The slug is derived from the title by the ServiceObserver.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'slug' => ['required', 'string', 'max:255', $this->uniqueSlugRule()],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.unique' => 'A service with this title already exists.',
        ];
    }

    /**
     * Soft-deleted rows still occupy the slug unique index.
     */
    protected function uniqueSlugRule(): Unique
    {
        $uniqueSlug = Rule::unique('services', 'slug');

        $service = $this->route('service');

        if ($service instanceof Service) {
            $uniqueSlug = $uniqueSlug->ignore($service->id);
        }

        return $uniqueSlug;
    }
}
