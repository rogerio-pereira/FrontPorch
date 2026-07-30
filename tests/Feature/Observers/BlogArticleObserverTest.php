<?php

use App\Models\BlogArticle;
use App\Models\User;

it('derives the slug from the title on create', function () {
    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Five Ways To Automate Intake',
                    ]);

    $slug = $article->slug;

    expect($slug)->toBe('five-ways-to-automate-intake');
});

it('keeps the slug when the title is unchanged', function () {
    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Five Ways To Automate Intake',
                        'category' => 'Branding',
                    ]);

    $article->update([
        'category' => 'Strategy',
    ]);

    $slug = $article->slug;

    expect($slug)->toBe('five-ways-to-automate-intake');
});

it('regenerates the slug when the title changes', function () {
    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Five Ways To Automate Intake',
                    ]);

    $article->update([
        'title' => 'Three Ways To Automate Intake',
    ]);

    $slug = $article->slug;

    expect($slug)->toBe('three-ways-to-automate-intake');
});

it('rejects a title that cannot produce a slug', function () {
    BlogArticle::factory()
        ->create([
            'title' => '###',
        ]);
})->throws(InvalidArgumentException::class);

it('credits the authenticated user on create', function () {
    $user = User::factory()
                ->create([
                    'name' => 'Dana Porch',
                ]);

    $this->actingAs($user);

    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Five Ways To Automate Intake',
                    ]);

    $publishedBy = $article->published_by;

    expect($publishedBy)->toBe('Dana Porch');
});

it('credits the app name without an authenticated user', function () {
    $article = BlogArticle::factory()
                    ->create();

    $publishedBy = $article->published_by;
    $appName = config('app.name');

    expect($publishedBy)->toBe($appName);
});
