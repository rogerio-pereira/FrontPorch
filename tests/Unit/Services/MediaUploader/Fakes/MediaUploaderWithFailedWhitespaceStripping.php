<?php

namespace Tests\Unit\Services\MediaUploader\Fakes;

use App\Services\MediaUploader;
use ReflectionMethod;

class MediaUploaderWithFailedWhitespaceStripping extends MediaUploader
{
    protected function stripWhitespace(string $data): ?string
    {
        return null;
    }

    public function storeDataUrlForTest(string $type, string $data, string $directory): string
    {
        $method = new ReflectionMethod(MediaUploader::class, 'storeDataUrl');

        return $method->invoke($this, $type, $data, $directory);
    }
}
