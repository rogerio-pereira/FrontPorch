<?php

namespace App\Http\Requests\Core;

use App\Concerns\ImageValidationRules;
use App\Models\BlogArticle;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class BlogArticleRequest extends FormRequest
{
    use ImageValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * The slug and the author are set by the BlogArticleObserver. Unique
     * titles keep observer-derived slugs unique as well. A missing image on
     * update keeps the one already stored for the article.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', $this->uniqueTitleRule()],
            'description' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => [$this->imageRequirement(), ...$this->imageFileRules()],
        ];
    }

    /**
     * Soft-deleted rows still occupy the title uniqueness check.
     */
    protected function uniqueTitleRule(): Unique
    {
        $uniqueTitle = Rule::unique('blog_articles', 'title');

        $article = $this->route('article');

        if ($article instanceof BlogArticle) {
            $uniqueTitle = $uniqueTitle->ignore($article->id);
        }

        return $uniqueTitle;
    }

    /**
     * Cover image is required on create and optional on update.
     */
    protected function imageRequirement(): string
    {
        if ($this->isMethod('post')) {
            return 'required';
        }

        return 'nullable';
    }
}
