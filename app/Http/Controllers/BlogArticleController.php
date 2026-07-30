<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use Inertia\Inertia;
use Inertia\Response;

class BlogArticleController extends Controller
{
    /**
     * Show an article by slug; soft-deleted ones are not found.
     */
    public function show(BlogArticle $article): Response
    {
        $publishedAt = $this->formatPublishedAt($article);

        $payload = [
            'published' => true,
            'title' => $article->title,
            'excerpt' => $article->description,
            'category' => $article->category,
            'publishedAt' => $publishedAt,
            'author' => $article->published_by,
            'coverImage' => $article->image,
            'coverAlt' => $article->title,
            'content' => $article->content,
        ];

        return Inertia::render('blog-article/BlogArticle', [
            'article' => $payload,
        ]);
    }

    /**
     * Format the article creation date for the public article page.
     */
    private function formatPublishedAt(BlogArticle $article): string
    {
        $createdAt = $article->created_at;

        if ($createdAt === null) {
            return '';
        }

        return $createdAt->format('F j, Y');
    }
}
