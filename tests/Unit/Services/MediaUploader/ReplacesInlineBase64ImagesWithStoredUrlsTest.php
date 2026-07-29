<?php

use App\Services\MediaUploader;
use Illuminate\Support\Facades\Storage;

it('replaces inline base64 images with stored urls', function () {
    Storage::fake();

    $payload = base64_encode('first-inline-image');
    $content = '<p>Intro</p><img src="data:image/png;base64,'.$payload.'"><p>Outro</p>';

    $processed = (new MediaUploader)->storeInlineImages($content, 'blog');

    expect($processed)->not->toContain('data:image');
    expect($processed)->toContain('blog/');
    expect($processed)->toContain('.png');
    expect(Storage::allFiles('blog'))->toHaveCount(1);
});
