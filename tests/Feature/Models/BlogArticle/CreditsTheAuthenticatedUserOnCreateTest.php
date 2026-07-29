<?php

use App\Models\BlogArticle;
use App\Models\User;

it('credits the authenticated user on create', function () {
    $user = User::factory()->create(['name' => 'Dana Porch']);

    $this->actingAs($user);

    $article = BlogArticle::factory()->create(['title' => 'Five Ways To Automate Intake']);

    expect($article->published_by)->toBe('Dana Porch');
    expect($article->slug)->toBe('five-ways-to-automate-intake');
});
