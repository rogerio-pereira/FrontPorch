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
        $paginator = BlogArticle::orderByDesc('created_at')->paginate(self::PER_PAGE);

        $articles = [];

        foreach ($paginator as $article) {
            $articles[] = [
                'id' => $article->id,
                'title' => $article->title,
                'excerpt' => $article->description,
                'category' => $article->category,
                'publishedAt' => (string) $article->created_at?->format('F j, Y'),
                'coverImage' => $article->image,
                'href' => route('blog.article', $article->slug, false),
            ];
        }

        return Inertia::render('blog/Blog', [
            'articles' => $articles,
            'pagination' => [
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
                'previousPageUrl' => $paginator->previousPageUrl(),
                'nextPageUrl' => $paginator->nextPageUrl(),
            ],
        ]);
    }
}
