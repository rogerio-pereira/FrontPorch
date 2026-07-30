<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MediaUploader
{
    /**
     * Store an uploaded file on the object storage disk and return its URL.
     */
    public function store(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory);

        if (! is_string($path)) {
            throw new RuntimeException('Unable to store the uploaded file.');
        }

        $url = Storage::url($path);

        return $url;
    }
}
