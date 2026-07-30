<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\BlogArticleRequest;
use App\Models\BlogArticle;
use App\Services\MediaUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;

class BlogArticleController extends Controller
{
    /**
     * Object storage directory for blog media.
     */
    protected const DIRECTORY = 'blog';

    /**
     * List the published articles, newest first.
     */
    public function index(): Response
    {
        $articles = BlogArticle::orderByDesc('created_at')
                        ->get();

        return Inertia::render('core/blog-articles/Index', compact('articles'));
    }

    /**
     * Show the form to create an article.
     */
    public function create(): Response
    {
        return Inertia::render('core/blog-articles/Form', [
            'article' => null,
        ]);
    }

    /**
     * Store a new article with its cover image.
     */
    public function store(BlogArticleRequest $request, MediaUploader $uploader): RedirectResponse
    {
        // The BlogArticleObserver sets the slug from the title and credits the
        // signed-in user as the author.
        $data = $request->validated();

        $image = $request->file('image');

        if (! $image instanceof UploadedFile) {
            abort(422);
        }

        $data['image'] = $uploader->store($image, self::DIRECTORY);

        BlogArticle::create($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Article created.'),
            ]
        );

        return to_route('core.blog.articles.index');
    }

    /**
     * Articles are edited from the index; there is no detail page.
     */
    public function show(): never
    {
        abort(404);
    }

    /**
     * Show the form to edit an article.
     */
    public function edit(BlogArticle $article): Response
    {
        return Inertia::render('core/blog-articles/Form', [
            'article' => $article,
        ]);
    }

    /**
     * Update an article, keeping the current cover image when none is sent.
     */
    public function update(BlogArticleRequest $request, BlogArticle $article, MediaUploader $uploader): RedirectResponse
    {
        // The BlogArticleObserver regenerates the slug when the title changes.
        $data = $request->validated();

        unset($data['image']);

        $image = $request->file('image');

        if ($image instanceof UploadedFile) {
            $data['image'] = $uploader->store($image, self::DIRECTORY);
        }

        $article->update($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Article updated.'),
            ]
        );

        return to_route('core.blog.articles.index');
    }

    /**
     * Soft delete an article so it disappears from the blog.
     */
    public function destroy(BlogArticle $article): RedirectResponse
    {
        $article->delete();

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Article deleted.'),
            ]
        );

        return to_route('core.blog.articles.index');
    }
}
