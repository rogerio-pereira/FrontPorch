<?php

use App\Models\BlogArticle;
use App\Models\User;

beforeEach()->flaky();

it('shows the blog articles admin screens to authenticated users', function (string $url, string $heading, ?string $submit) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $page = visit($url)
                ->waitForEvent('networkidle')
                ->assertSee($heading);

    if ($submit !== null) {
        $page->assertPresent($submit);
    }
})->with([
    'index' => ['/core/blog/articles', 'Blog articles', null],
    'create' => ['/core/blog/articles/create', 'New article', '@article-submit'],
]);

it('shows the article create form with the image field', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    visit('/core/blog/articles/create')
        ->waitForEvent('networkidle')
        ->assertSee('New article')
        ->assertSee('Title')
        ->assertSee('Description')
        ->assertSee('Category')
        ->assertSee('Content')
        ->assertSee('Image')
        ->assertPresent('@rich-text-editor')
        ->assertPresent('@rich-text-toolbar')
        ->assertPresent('@article-image')
        ->assertPresent('@article-submit');
});

it('shows the blog articles edit form to authenticated users', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Why your website should feel like a front porch',
                        'image' => '/images/blog-article/cover.png',
                    ]);

    $url = "/core/blog/articles/{$article->id}/edit";

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee('Edit article')
        ->assertPresent('@article-submit');
});

it('edits a blog article from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Original article title',
                        'description' => 'Original description.',
                        'category' => 'Strategy',
                        'content' => '<p>Original content.</p>',
                        'image' => '/images/blog-article/cover.png',
                    ]);

    $url = "/core/blog/articles/{$article->id}/edit";

    visit($url)
        ->waitForEvent('networkidle')
        ->type('title', 'Updated article title')
        ->click('@article-submit')
        ->waitForText('Updated article title')
        ->assertPathIs('/core/blog/articles');

    $slug = $article->refresh()
                ->slug;

    expect($slug)->toBe('updated-article-title');
});

it('deletes a blog article from the admin index', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Delete this article',
                        'image' => '/images/blog-article/cover.png',
                    ]);

    visit('/core/blog/articles')
        ->waitForEvent('networkidle')
        ->assertSee('Delete this article')
        ->click("@article-delete-{$article->id}")
        ->waitForText('No articles yet.')
        ->assertDontSee('Delete this article');

    $found = BlogArticle::find($article->id);

    expect($found)->toBeNull();
});
