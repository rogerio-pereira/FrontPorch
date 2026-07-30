<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    /**
     * Articles per page on the public blog.
     */
    protected const PER_PAGE = 15;

    public function __invoke(): Response
    {
        $articles = BlogArticle::orderByDesc('created_at')
                        ->paginate(self::PER_PAGE);

        return Inertia::render('blog/Blog', compact('articles'));
    }
}
