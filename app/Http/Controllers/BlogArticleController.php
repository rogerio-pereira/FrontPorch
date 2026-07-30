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
        $publishedAt = '';
        $createdAt = $article->created_at;

        if ($createdAt !== null) {
            $publishedAt = $createdAt->format('F j, Y');
        }

        return Inertia::render('blog-article/BlogArticle', [
            'article' => [
                'published' => true,
                'title' => $article->title,
                'excerpt' => $article->description,
                'category' => $article->category,
                'publishedAt' => $publishedAt,
                'author' => $article->published_by,
                'coverImage' => $article->image,
                'coverAlt' => $article->title,
                'content' => $article->content,
            ],
        ]);
    }
}
