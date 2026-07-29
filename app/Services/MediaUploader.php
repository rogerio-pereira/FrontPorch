<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class MediaUploader
{
    /**
     * Inline base64 images produced by the rich text editor.
     */
    protected const DATA_URL_PATTERN = '/data:image\/(?P<type>png|jpeg|jpg|gif|webp|svg\+xml);base64,(?P<data>[A-Za-z0-9+\/=\s]+)/i';

    /**
     * MIME subtypes that do not map directly to a file extension.
     *
     * @var array<string, string>
     */
    protected const EXTENSIONS = [
        'jpeg' => 'jpg',
        'svg+xml' => 'svg',
    ];

    /**
     * Store an uploaded file on the object storage disk and return its URL.
     */
    public function store(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory);

        if (! is_string($path)) {
            throw new RuntimeException('Unable to store the uploaded file.');
        }

        return Storage::url($path);
    }

    /**
     * Replace inline base64 images in editor HTML with stored object URLs.
     *
     * The editor embeds pasted or uploaded images as data URLs; they are only
     * persisted when the parent resource form is submitted.
     */
    public function storeInlineImages(string $content, string $directory): string
    {
        $processed = $this->replaceInlineDataUrls($content, $directory);

        if (! is_string($processed)) {
            return $content;
        }

        return $processed;
    }

    /**
     * Persist a single data URL payload and return its public URL.
     */
    protected function storeDataUrl(string $type, string $data, string $directory): string
    {
        $normalized = $this->stripWhitespace($data);

        if (! is_string($normalized)) {
            $normalized = $data;
        }

        $binary = base64_decode($normalized, true);

        if ($binary === false) {
            return 'data:image/'.$type.';base64,'.$data;
        }

        $path = $directory.'/'.Str::uuid()->toString().'.'.$this->extensionFor($type);

        Storage::put($path, $binary);

        return Storage::url($path);
    }

    /**
     * Replace matching data URLs in editor HTML, or null when PCRE fails.
     */
    protected function replaceInlineDataUrls(string $content, string $directory): ?string
    {
        /** @var string|null $processed */
        $processed = preg_replace_callback(
            self::DATA_URL_PATTERN,
            fn (array $matches): string => $this->storeDataUrl($matches['type'], $matches['data'], $directory),
            $content,
        );

        return $processed;
    }

    /**
     * Remove whitespace from a base64 payload, or null when PCRE fails.
     */
    protected function stripWhitespace(string $data): ?string
    {
        /** @var string|null $normalized */
        $normalized = preg_replace('/\s+/', '', $data);

        return $normalized;
    }

    /**
     * Resolve the file extension for an image MIME subtype.
     */
    protected function extensionFor(string $type): string
    {
        $normalized = strtolower($type);

        if (array_key_exists($normalized, self::EXTENSIONS)) {
            return self::EXTENSIONS[$normalized];
        }

        return $normalized;
    }
}
