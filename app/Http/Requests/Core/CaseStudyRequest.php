<?php

namespace App\Http\Requests\Core;

use App\Concerns\ImageValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CaseStudyRequest extends FormRequest
{
    use ImageValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * The slug is derived from the title by the CaseStudyObserver. Gallery
     * images are uploaded with the parent form; the first one is the cover.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'client' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'challenge' => ['required', 'string'],
            'content' => ['required', 'string'],
            'services' => ['nullable', 'array'],
            'services.*' => ['uuid', 'exists:services,id'],
            'images' => ['nullable', 'array'],
            'images.*' => $this->imageFileRules(),
            'image_alts' => ['nullable', 'array'],
            'image_alts.*' => ['nullable', 'string', 'max:255'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['uuid', 'exists:case_study_images,id'],
        ];
    }
}
