<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function __invoke(): Response
    {
        /*
         * TODO: replace with Article::published()->latest()->get() (or equivalent).
         *
         * Expected Inertia prop `articles`:
         * list<{
         *   id: int,
         *   title: string,
         *   excerpt: string,
         *   category: string,
         *   publishedAt: string,
         *   coverImage: string,
         *   href: string,
         * }>
         *
         * Empty list → Blog page shows the empty state.
         */
        $articles = [
            [
                'id' => 1,
                'title' => 'Why your website should feel like a front porch',
                'excerpt' => 'A calm, clear online presence helps small businesses earn trust before the first phone call.',
                'category' => 'Website strategy',
                'publishedAt' => 'June 18, 2026',
                'coverImage' => '/images/blog/article-cover.png',
                'href' => '/blog/article/1',
            ],
        ];

        return Inertia::render('blog/Blog', [
            'articles' => $articles,
        ]);
    }
}
