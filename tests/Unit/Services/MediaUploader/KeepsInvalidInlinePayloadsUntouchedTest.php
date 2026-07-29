<?php

use App\Services\MediaUploader;
use Illuminate\Support\Facades\Storage;

it('keeps invalid inline payloads untouched', function () {
    Storage::fake();

    $content = '<img src="data:image/png;base64,====">';

    expect((new MediaUploader)->storeInlineImages($content, 'blog'))->toBe($content);
    expect(Storage::allFiles())->toBeEmpty();
});
