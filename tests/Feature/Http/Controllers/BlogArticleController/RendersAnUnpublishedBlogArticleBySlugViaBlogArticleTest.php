<?php

use Inertia\Testing\AssertableInertia as Assert;

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
