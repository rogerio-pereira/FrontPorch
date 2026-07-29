<?php

use Illuminate\Support\Facades\Storage;
use Tests\Unit\Services\MediaUploader\Fakes\MediaUploaderWithFailedInlineReplacement;

it('returns the original content when inline replacement fails', function () {
    Storage::fake();

    $content = '<img src="data:image/png;base64,'.base64_encode('inline-image').'">';

    expect((new MediaUploaderWithFailedInlineReplacement)->storeInlineImages($content, 'blog'))
        ->toBe($content);
    expect(Storage::allFiles())->toBeEmpty();
});
