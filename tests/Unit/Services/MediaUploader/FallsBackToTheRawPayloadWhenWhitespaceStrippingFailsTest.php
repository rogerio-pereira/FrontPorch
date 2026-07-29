<?php

use Illuminate\Support\Facades\Storage;
use Tests\Unit\Services\MediaUploader\Fakes\MediaUploaderWithFailedWhitespaceStripping;

it('falls back to the raw payload when whitespace stripping fails', function () {
    Storage::fake();

    $payload = base64_encode('inline-image');
    $url = (new MediaUploaderWithFailedWhitespaceStripping)
        ->storeDataUrlForTest('png', $payload, 'blog');

    expect($url)->toContain('blog/');
    expect($url)->toContain('.png');
    expect(Storage::allFiles('blog'))->toHaveCount(1);
});
