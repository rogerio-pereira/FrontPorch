<?php

use App\Services\MediaUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores uploaded files and returns the public url', function () {
    Storage::fake();

    $url = (new MediaUploader)->store(UploadedFile::fake()->create('cover.jpg', 12), 'blog');

    expect($url)->toContain('blog/');
    expect(Storage::allFiles('blog'))->toHaveCount(1);
});
