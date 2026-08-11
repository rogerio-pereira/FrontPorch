<?php

namespace App\Ai\Tools;

use App\Models\BlogArticle;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CreateBlogArticleTool implements Tool
{
    public function name(): string
    {
        return 'create_blog_article';
    }

    public function description(): Stringable|string
    {
        return 'Create and publish one blog article (title, description, category, HTML content, cover image URL).';
    }

    public function handle(Request $request): Stringable|string
    {
        // BlogArticleObserver sets slug and published_by.
        $article = BlogArticle::create([
            'title' => (string) $request->string('title'),
            'description' => (string) $request->string('description'),
            'category' => (string) $request->string('category'),
            'content' => (string) $request->string('content'),
            'image' => (string) $request->string('image'),
        ]);

        return "Published article {$article->slug}";
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->required(),
            'description' => $schema->string()->required(),
            'category' => $schema->string()->required(),
            'content' => $schema->string()->required(),
            'image' => $schema->string()->required(),
        ];
    }
}
