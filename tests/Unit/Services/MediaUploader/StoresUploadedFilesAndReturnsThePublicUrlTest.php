<?php

use App\Services\MediaUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores uploaded files and returns the public url', function () {
    Storage::fake();

    $file = UploadedFile::fake()->create('cover.jpg', 12);
    $uploader = new MediaUploader;
    $url = $uploader->store($file, 'blog');

    expect($url)->toContain('blog/');
    expect(Storage::allFiles('blog'))->toHaveCount(1);
});
