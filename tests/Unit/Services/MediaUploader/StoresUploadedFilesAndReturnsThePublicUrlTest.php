<?php

use App\Services\MediaUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores uploaded files and returns the public url', function () {
    Storage::fake();

    $fileFactory = UploadedFile::fake();
    $file = $fileFactory->create('cover.jpg', 12);
    $uploader = new MediaUploader;
    $url = $uploader->store($file, 'blog');
    $storedFiles = Storage::allFiles('blog');

    expect($url)
        ->toContain('blog/');
    expect($storedFiles)
        ->toHaveCount(1);
});
