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
