<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class MediaUploader
{
    /**
     * Store an uploaded file on the object storage disk and return its URL.
     */
    public function store(UploadedFile $file, string $directory): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid()->toString().'.'.$extension;

        $path = Storage::putFileAs($directory, $file, $filename);

        if (! is_string($path)) {
            throw new RuntimeException('Unable to store the uploaded file.');
        }

        $url = Storage::url($path);

        return $url;
    }
}
