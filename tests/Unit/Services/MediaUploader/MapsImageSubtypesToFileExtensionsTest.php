<?php

use App\Services\MediaUploader;
use Illuminate\Support\Facades\Storage;

it('maps image subtypes to file extensions', function () {
    Storage::fake();

    $payload = base64_encode('inline-image');
    $content = '<img src="data:image/JPEG;base64,'.$payload.'">'
        .'<img src="data:image/svg+xml;base64,'.$payload.'">';

    $processed = (new MediaUploader)->storeInlineImages($content, 'case-studies');

    expect($processed)->toContain('.jpg');
    expect($processed)->toContain('.svg');
    expect(Storage::allFiles('case-studies'))->toHaveCount(2);
});
