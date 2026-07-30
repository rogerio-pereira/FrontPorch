<?php

namespace App\Http\Requests\Core;

use App\Concerns\ImageValidationRules;
use App\Models\CaseStudy;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class CaseStudyRequest extends FormRequest
{
    use ImageValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * The slug is derived from the title by the CaseStudyObserver. Unique
     * titles keep observer-derived slugs unique as well. Gallery images are
     * uploaded with the parent form; the first one is the cover.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', $this->uniqueTitleRule()],
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

    /**
     * Soft-deleted rows still occupy the title uniqueness check.
     */
    protected function uniqueTitleRule(): Unique
    {
        $uniqueTitle = Rule::unique('case_studies', 'title');

        $caseStudy = $this->route('case_study');

        if ($caseStudy instanceof CaseStudy) {
            $uniqueTitle = $uniqueTitle->ignore($caseStudy->id);
        }

        return $uniqueTitle;
    }
}
