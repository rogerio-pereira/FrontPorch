<?php

namespace Tests\Unit\Services\MediaUploader\Fakes;

use App\Services\MediaUploader;

class MediaUploaderWithFailedInlineReplacement extends MediaUploader
{
    protected function replaceInlineDataUrls(string $content, string $directory): ?string
    {
        return null;
    }
}
