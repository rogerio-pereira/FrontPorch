<?php

namespace App\Observers;

use App\Models\BlogArticle;
use App\Models\User;
use App\Support\UniqueSlug;
use Illuminate\Support\Facades\Auth;

class BlogArticleObserver
{
    /**
     * Handle the BlogArticle "creating" event.
     */
    public function creating(BlogArticle $article): void
    {
        $article->published_by = $this->resolvePublishedBy();
        $article->slug = UniqueSlug::uniqueSlug($article->title, BlogArticle::class);
    }

    /**
     * Handle the BlogArticle "updating" event.
     */
    public function updating(BlogArticle $article): void
    {
        if (! $article->isDirty('title')) {
            return;
        }

        $article->slug = UniqueSlug::uniqueSlug($article->title, BlogArticle::class, $article->id);
    }

    /**
     * Resolve the author name credited on the article.
     */
    protected function resolvePublishedBy(): string
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return 'System';
        }

        return $user->name;
    }
}
