<?php

use App\Models\BlogArticle;

it('keeps the slug when the title is unchanged', function () {
    $article = BlogArticle::factory()->create([
        'title' => 'Five Ways To Automate Intake',
        'category' => 'Branding',
    ]);

    $article->update(['category' => 'Strategy']);

    expect($article->slug)->toBe('five-ways-to-automate-intake');
});
