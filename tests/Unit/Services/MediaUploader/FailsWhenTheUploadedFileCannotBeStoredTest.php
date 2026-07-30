<?php

use App\Services\MediaUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('fails when the uploaded file cannot be stored', function () {
    Storage::shouldReceive('putFileAs')
        ->once()
        ->andReturn(false);

    $fileFactory = UploadedFile::fake();
    $file = $fileFactory->create('cover.jpg', 12);
    $uploader = new MediaUploader;
    $store = fn () => $uploader->store($file, 'blog');

    expect($store)
        ->toThrow(RuntimeException::class, 'Unable to store the uploaded file.');
});
