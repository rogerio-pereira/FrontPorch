<?php

namespace App\Http\Requests\Core;

use App\Concerns\ImageValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BlogArticleUpdateRequest extends FormRequest
{
    use ImageValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * A missing image keeps the one already stored for the article.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', ...$this->imageFileRules()],
        ];
    }
}
