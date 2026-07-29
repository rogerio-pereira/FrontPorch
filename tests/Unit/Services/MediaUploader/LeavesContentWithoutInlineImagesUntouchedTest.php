<?php

use App\Services\MediaUploader;
use Illuminate\Support\Facades\Storage;

it('leaves content without inline images untouched', function () {
    Storage::fake();

    $content = '<p>Nothing to upload here.</p><img src="https://images.example.com/blog/cover.jpg">';

    expect((new MediaUploader)->storeInlineImages($content, 'blog'))->toBe($content);
    expect(Storage::allFiles())->toBeEmpty();
});
