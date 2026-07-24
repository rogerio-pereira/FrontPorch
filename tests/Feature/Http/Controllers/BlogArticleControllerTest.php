<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders a published blog article from backend props', function () {
    $this->get('/blog/article/1')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('blog-article/BlogArticle')
            ->has('article', fn (Assert $article) => $article
                ->where('published', true)
                ->has('title')
                ->has('excerpt')
                ->has('category')
                ->has('publishedAt')
                ->has('author')
                ->has('coverImage')
                ->has('coverAlt')
                ->has('body')
            )
        );
});

it('renders an unpublished blog article by slug via BlogArticle', function () {
    $this->get('/blog/your-website-works-when-you-are-not')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('blog-article/BlogArticle')
            ->has('article', fn (Assert $article) => $article
                ->where('published', false)
                ->where('title', 'Your Website Works When You Are Not')
                ->has('coverImage')
            )
        );
});

it('returns not found for unknown blog articles', function () {
    $this->get('/blog/article/99')->assertNotFound();
});
