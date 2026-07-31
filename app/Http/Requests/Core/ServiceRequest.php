<?php

namespace App\Http\Requests\Core;

use App\Models\Service;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class ServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * The slug is derived from the title by the ServiceObserver.
     * Unique titles keep observer-derived slugs unique as well.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', $this->uniqueTitleRule()],
            'description' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Soft-deleted rows still occupy the title uniqueness check.
     */
    protected function uniqueTitleRule(): Unique
    {
        $uniqueTitle = Rule::unique('services', 'title');

        $service = $this->route('service');

        if ($service instanceof Service) {
            $uniqueTitle = $uniqueTitle->ignore($service->id);
        }

        return $uniqueTitle;
    }
}
