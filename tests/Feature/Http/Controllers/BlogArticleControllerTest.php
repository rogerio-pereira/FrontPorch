<?php

use App\Models\BlogArticle;
use Inertia\Testing\AssertableInertia as Assert;

it('renders a published article by slug', function () {
    BlogArticle::factory()->create([
        'title' => 'Why your website should feel like a front porch',
        'description' => 'A calm, clear online presence helps small businesses earn trust.',
        'category' => 'Website strategy',
        'content' => '<p>Most people meet your business online.</p>',
        'image' => '/images/blog-article/cover.png',
    ]);

    $this->get('/blog/article/why-your-website-should-feel-like-a-front-porch')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('blog-article/BlogArticle')
            ->has('article', fn (Assert $article) => $article
                ->where('published', true)
                ->where('title', 'Why your website should feel like a front porch')
                ->where('excerpt', 'A calm, clear online presence helps small businesses earn trust.')
                ->where('category', 'Website strategy')
                ->where('content', '<p>Most people meet your business online.</p>')
                ->where('coverImage', '/images/blog-article/cover.png')
                ->where('coverAlt', 'Why your website should feel like a front porch')
                ->where('author', 'System')
                ->has('publishedAt')
            )
        );
});

it('returns not found for unknown articles', function () {
    $this->get('/blog/article/not-a-real-article')->assertNotFound();
});

it('returns not found for soft deleted articles', function () {
    $article = BlogArticle::factory()->create(['title' => 'Retired article']);
    $article->delete();

    $this->get('/blog/article/retired-article')->assertNotFound();
});
