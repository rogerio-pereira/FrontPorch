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
        $paginator = BlogArticle::orderByDesc('created_at')
                        ->paginate(self::PER_PAGE);

        $articles = [];

        foreach ($paginator as $article) {
            $publishedAt = '';
            $createdAt = $article->created_at;

            if ($createdAt !== null) {
                $publishedAt = $createdAt->format('F j, Y');
            }

            $href = route('blog.article', $article->slug, false);

            $articles[] = [
                'id' => $article->id,
                'title' => $article->title,
                'excerpt' => $article->description,
                'category' => $article->category,
                'publishedAt' => $publishedAt,
                'coverImage' => $article->image,
                'href' => $href,
            ];
        }

        $pagination = [
            'currentPage' => $paginator->currentPage(),
            'lastPage' => $paginator->lastPage(),
            'previousPageUrl' => $paginator->previousPageUrl(),
            'nextPageUrl' => $paginator->nextPageUrl(),
        ];

        return Inertia::render('blog/Blog', [
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
    }
}
