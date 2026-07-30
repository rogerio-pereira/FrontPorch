<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\MediaUploadRequest;
use App\Services\MediaUploader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class MediaUploadController extends Controller
{
    /**
     * Store an inline editor image and return its public URL.
     */
    public function store(MediaUploadRequest $request, MediaUploader $uploader): JsonResponse
    {
        $file = $request->file('file');

        if (! $file instanceof UploadedFile) {
            abort(422);
        }

        $directory = $request->validated('directory');

        $url = $uploader->store($file, $directory);

        return response()->json([
            'url' => $url,
        ]);
    }
}
