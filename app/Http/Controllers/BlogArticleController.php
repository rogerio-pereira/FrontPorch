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
        return Inertia::render('blog-article/BlogArticle', compact('article'));
    }
}
