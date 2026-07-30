<?php

namespace App\Observers;

use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use InvalidArgumentException;

class BlogArticleObserver
{
    /**
     * Handle the BlogArticle "creating" event.
     */
    public function creating(BlogArticle $article): void
    {
        $article->published_by = $this->resolvePublishedBy();
        $article->slug = $this->slugFromTitle($article->title);
    }

    /**
     * Handle the BlogArticle "updating" event.
     */
    public function updating(BlogArticle $article): void
    {
        if (! $article->isDirty('title')) {
            return;
        }

        $article->slug = $this->slugFromTitle($article->title);
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

    /**
     * Derive a URL slug from the article title.
     */
    protected function slugFromTitle(string $title): string
    {
        $slug = Str::slug($title);

        if ($slug === '') {
            throw new InvalidArgumentException('An article title must produce a non-empty slug.');
        }

        return $slug;
    }
}
