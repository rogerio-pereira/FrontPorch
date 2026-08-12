<?php

namespace App\Services;

use GdImage;
use RuntimeException;

class ImageCompressor
{
    /**
     * Re-encode an image for the web (JPEG), keeping high visual quality
     * while cutting file size substantially — similar to Photoshop "Save for Web".
     */
    public function forWeb(string $binary, int $quality = 82): string
    {
        if ($quality < 0 || $quality > 100) {
            throw new RuntimeException('JPEG quality must be between 0 and 100.');
        }

        $source = @imagecreatefromstring($binary);

        if ($source === false) {
            throw new RuntimeException('Unable to decode image for web compression.');
        }

        $canvas = $this->flattenOntoWhiteBackground($source);
        imagedestroy($source);

        return $this->encodeToJpeg($canvas, $quality);
    }

    protected function createCanvas(int $width, int $height): GdImage|false
    {
        return imagecreatetruecolor($width, $height);
    }

    /**
     * @return array{0: bool, 1: string}
     */
    protected function attemptJpegEncode(GdImage $canvas, int $quality): array
    {
        ob_start();
        $encoded = $this->writeJpeg($canvas, $quality);
        $contents = (string) ob_get_clean();

        if ($encoded === true) {
            return [true, $contents];
        }

        return [false, $contents];
    }

    protected function writeJpeg(GdImage $canvas, int $quality): bool
    {
        return imagejpeg($canvas, null, $quality);
    }

    private function encodeToJpeg(GdImage $canvas, int $quality): string
    {
        [$encoded, $contents] = $this->attemptJpegEncode($canvas, $quality);
        imagedestroy($canvas);

        if ($encoded === false || $contents === '') {
            throw new RuntimeException('Unable to encode image for the web.');
        }

        return $contents;
    }

    private function flattenOntoWhiteBackground(GdImage $source): GdImage
    {
        $width = imagesx($source);
        $height = imagesy($source);
        $canvas = $this->createCanvas($width, $height);

        if ($canvas === false) {
            throw new RuntimeException('Unable to create image canvas for compression.');
        }

        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagealphablending($canvas, true);
        imagecopy($canvas, $source, 0, 0, 0, 0, $width, $height);

        return $canvas;
    }
}
