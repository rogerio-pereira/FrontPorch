<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\BlogArticleStoreRequest;
use App\Http\Requests\Core\BlogArticleUpdateRequest;
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
        $articles = [];

        foreach (BlogArticle::orderByDesc('created_at')->get() as $article) {
            $articles[] = $this->props($article);
        }

        return Inertia::render('core/blog-articles/Index', [
            'articles' => $articles,
        ]);
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
    public function store(BlogArticleStoreRequest $request, MediaUploader $uploader): RedirectResponse
    {
        // The BlogArticleObserver sets the slug from the title and credits the
        // signed-in user as the author.
        $attributes = $this->attributes($request->safe()->only(['title', 'description', 'category', 'content']), $uploader);

        $image = $request->file('image');

        if ($image instanceof UploadedFile) {
            $attributes['image'] = $uploader->store($image, self::DIRECTORY);
        }

        BlogArticle::create($attributes);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Article created.')]);

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
            'article' => $this->props($article),
        ]);
    }

    /**
     * Update an article, keeping the current cover image when none is sent.
     */
    public function update(BlogArticleUpdateRequest $request, BlogArticle $article, MediaUploader $uploader): RedirectResponse
    {
        // The BlogArticleObserver regenerates the slug when the title changes.
        $attributes = $this->attributes($request->safe()->only(['title', 'description', 'category', 'content']), $uploader);

        $image = $request->file('image');

        if ($image instanceof UploadedFile) {
            $attributes['image'] = $uploader->store($image, self::DIRECTORY);
        }

        $article->update($attributes);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Article updated.')]);

        return to_route('core.blog.articles.index');
    }

    /**
     * Soft delete an article so it disappears from the blog.
     */
    public function destroy(BlogArticle $article): RedirectResponse
    {
        $article->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Article deleted.')]);

        return to_route('core.blog.articles.index');
    }

    /**
     * Move inline editor images to object storage before saving the content.
     *
     * @param  array<string, string>  $attributes
     * @return array<string, string>
     */
    protected function attributes(array $attributes, MediaUploader $uploader): array
    {
        $attributes['content'] = $uploader->storeInlineImages($attributes['content'], self::DIRECTORY);

        return $attributes;
    }

    /**
     * Shape an article for the admin pages.
     *
     * @return array{id: string, title: string, slug: string, description: string, category: string, content: string, image: string, published_by: string}
     */
    protected function props(BlogArticle $article): array
    {
        return [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'description' => $article->description,
            'category' => $article->category,
            'content' => $article->content,
            'image' => $article->image,
            'published_by' => $article->published_by,
        ];
    }
}
