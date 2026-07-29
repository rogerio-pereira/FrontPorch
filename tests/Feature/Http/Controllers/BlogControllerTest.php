<?php

use App\Models\BlogArticle;
use Inertia\Testing\AssertableInertia as Assert;

it('renders blog listing from articles', function () {
    $article = BlogArticle::factory()->create([
        'title' => 'Why your website should feel like a front porch',
        'description' => 'A calm, clear online presence helps small businesses earn trust.',
        'category' => 'Website strategy',
        'image' => '/images/blog-article/cover.png',
    ]);

    $this->get('/blog')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('blog/Blog')
            ->has('articles', 1)
            ->has('articles.0', fn (Assert $item) => $item
                ->where('id', $article->id)
                ->where('title', 'Why your website should feel like a front porch')
                ->where('excerpt', 'A calm, clear online presence helps small businesses earn trust.')
                ->where('category', 'Website strategy')
                ->where('coverImage', '/images/blog-article/cover.png')
                ->where('href', '/blog/article/why-your-website-should-feel-like-a-front-porch')
                ->has('publishedAt')
            )
            ->has('pagination', fn (Assert $pagination) => $pagination
                ->where('currentPage', 1)
                ->where('lastPage', 1)
                ->where('previousPageUrl', null)
                ->where('nextPageUrl', null)
            )
        );
});

it('paginates the blog at fifteen articles per page', function () {
    BlogArticle::factory(16)->create();

    $this->get('/blog')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('articles', 15)
            ->has('pagination', fn (Assert $pagination) => $pagination
                ->where('currentPage', 1)
                ->where('lastPage', 2)
                ->where('previousPageUrl', null)
                ->has('nextPageUrl')
            )
        );
});

it('hides soft deleted articles from the blog', function () {
    BlogArticle::factory()->softDeleted()->create();

    $this->get('/blog')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->has('articles', 0));
});
