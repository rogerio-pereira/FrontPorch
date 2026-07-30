<?php

use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()
                ->create([
                    'name' => 'Amelia Porch',
                ]);

    $this->actingAs($user);

    Storage::fake();
});

it('lists the articles', function () {
    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Why your website should feel like a front porch',
                        'category' => 'Website strategy',
                    ]);

    $response = $this->get('/core/blog/articles');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/blog-articles/Index')
        ->has('articles', 1)
        ->has('articles.0', fn (Assert $props) => $props
            ->where('id', $article->id)
            ->where('title', 'Why your website should feel like a front porch')
            ->where('slug', 'why-your-website-should-feel-like-a-front-porch')
            ->where('category', 'Website strategy')
            ->etc()
        )
    );
});

it('shows the form to create an article', function () {
    $response = $this->get('/core/blog/articles/create');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/blog-articles/Form')
        ->where('article', null)
    );
});

it('creates an article with a cover image and credits the author', function () {
    $response = $this->post(
        '/core/blog/articles',
        [
            'title' => 'Why your website should feel like a front porch',
            'description' => 'A calm, clear online presence earns trust.',
            'category' => 'Website strategy',
            'content' => '<p>Most people meet your business online.</p>',
            'image' => UploadedFile::fake()->create('cover.jpg', 12),
        ]
    );

    $response->assertRedirect('/core/blog/articles');

    $article = BlogArticle::where('slug', 'why-your-website-should-feel-like-a-front-porch')
                    ->firstOrFail();

    $publishedBy = $article->published_by;
    expect($publishedBy)->toBe('Amelia Porch');

    $image = $article->image;
    expect($image)->toContain('blog/');

    $storedFiles = Storage::allFiles('blog');
    expect($storedFiles)->toHaveCount(1);
});

it('validates the article payload', function () {
    $response = $this->post(
        '/core/blog/articles',
        [
            'title' => '',
            'description' => '',
            'category' => '',
            'content' => '',
        ]
    );

    $response->assertSessionHasErrors([
        'title',
        'description',
        'category',
        'content',
        'image',
    ]);
});

it('rejects a duplicate title', function () {
    BlogArticle::factory()
        ->create([
            'title' => 'Why your website should feel like a front porch',
        ]);

    $response = $this->post(
        '/core/blog/articles',
        [
            'title' => 'Why your website should feel like a front porch',
            'description' => 'A calm, clear online presence earns trust.',
            'category' => 'Website strategy',
            'content' => '<p>Most people meet your business online.</p>',
            'image' => UploadedFile::fake()->create('cover.jpg', 12),
        ]
    );

    $response->assertSessionHasErrors([
        'title',
    ]);
});

it('shows the form to edit an article', function () {
    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Why your website should feel like a front porch',
                    ]);

    $url = "/core/blog/articles/{$article->id}/edit";

    $response = $this->get($url);

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/blog-articles/Form')
        ->has('article', fn (Assert $props) => $props
            ->where('id', $article->id)
            ->where('title', 'Why your website should feel like a front porch')
            ->etc()
        )
    );
});

it('updates an article and keeps the current image', function () {
    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Why your website should feel like a front porch',
                        'image' => '/images/blog-article/cover.png',
                    ]);

    $url = "/core/blog/articles/{$article->id}";

    $response = $this->put(
        $url,
        [
            'title' => 'Why your website should feel like a porch swing',
            'description' => 'A calm, clear online presence earns trust.',
            'category' => 'Website strategy',
            'content' => '<p>Updated body.</p>',
        ]
    );

    $response->assertRedirect('/core/blog/articles');

    $article->refresh();

    $slug = $article->slug;
    expect($slug)->toBe('why-your-website-should-feel-like-a-porch-swing');

    $image = $article->image;
    expect($image)->toBe('/images/blog-article/cover.png');

    $content = $article->content;
    expect($content)->toBe('<p>Updated body.</p>');
});

it('replaces the image of an article when a new one is uploaded', function () {
    $article = BlogArticle::factory()
                    ->create([
                        'image' => '/images/blog-article/cover.png',
                    ]);

    $url = "/core/blog/articles/{$article->id}";

    $response = $this->put(
        $url,
        [
            'title' => $article->title,
            'description' => $article->description,
            'category' => $article->category,
            'content' => $article->content,
            'image' => UploadedFile::fake()->create('new-cover.jpg', 12),
        ]
    );

    $response->assertRedirect('/core/blog/articles');

    $image = $article->refresh()->image;
    expect($image)->toContain('blog/');

    $storedFiles = Storage::allFiles('blog');
    expect($storedFiles)->toHaveCount(1);
});

it('soft deletes an article', function () {
    $article = BlogArticle::factory()
                    ->create();

    $url = "/core/blog/articles/{$article->id}";

    $response = $this->delete($url);

    $response->assertRedirect('/core/blog/articles');

    $found = BlogArticle::find($article->id);
    expect($found)->toBeNull();

    $trashed = BlogArticle::withTrashed()
                    ->find($article->id);

    expect($trashed)->not->toBeNull();
});

it('has no detail page for articles', function () {
    $article = BlogArticle::factory()
                    ->create();

    $url = "/core/blog/articles/{$article->id}";

    $response = $this->get($url);

    $response->assertNotFound();
});
