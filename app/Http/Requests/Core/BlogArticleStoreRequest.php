<?php

namespace App\Http\Requests\Core;

use App\Concerns\ImageValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BlogArticleStoreRequest extends FormRequest
{
    use ImageValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * The slug and the author are set by the BlogArticleObserver.
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
            'image' => ['required', ...$this->imageFileRules()],
        ];
    }
}
