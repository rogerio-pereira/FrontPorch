<?php

use App\Services\MediaUploader;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

it('fails when the uploaded file cannot be stored', function () {
    $disk = Mockery::mock(Filesystem::class);
    $disk->shouldReceive('putFileAs')->once()->andReturn(false);

    $filesystem = Mockery::mock(FilesystemFactory::class);
    $filesystem->shouldReceive('disk')->with(null)->andReturn($disk);

    $this->app->instance(FilesystemFactory::class, $filesystem);

    expect(fn () => (new MediaUploader)->store(UploadedFile::fake()->create('cover.jpg', 12), 'blog'))
        ->toThrow(RuntimeException::class, 'Unable to store the uploaded file.');
});
