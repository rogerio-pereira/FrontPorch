<?php

namespace App\Http\Requests\Core;

use App\Concerns\ImageValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
{
    use ImageValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'directory' => ['required', 'string', 'in:blog,case-studies'],
            'file' => ['required', ...$this->imageFileRules()],
        ];
    }
}
