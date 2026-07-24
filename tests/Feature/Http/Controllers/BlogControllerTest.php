<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders blog listing from backend props', function () {
    $this->get('/blog')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('blog/Blog')
            ->has('articles', 1)
            ->has('articles.0', fn (Assert $item) => $item
                ->has('id')
                ->has('title')
                ->has('excerpt')
                ->has('category')
                ->has('publishedAt')
                ->has('coverImage')
                ->has('href')
                ->where('href', '/blog/article/1')
            )
        );
});
