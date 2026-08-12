<?php

use App\Services\ImageCompressor;

it('reencodes a png into a smaller jpeg for the web', function () {
    $png = createWebCompressionTestPng(640, 480);
    $jpeg = (new ImageCompressor)->forWeb($png);

    expect(strlen($jpeg))->toBeLessThan(strlen($png))
        ->and(substr($jpeg, 0, 2))->toBe("\xFF\xD8");
});

it('rejects invalid jpeg quality above one hundred', function () {
    expect(fn () => (new ImageCompressor)->forWeb(createWebCompressionTestPng(8, 8), 101))
        ->toThrow(RuntimeException::class, 'JPEG quality must be between 0 and 100.');
});

it('rejects invalid jpeg quality below zero', function () {
    expect(fn () => (new ImageCompressor)->forWeb(createWebCompressionTestPng(8, 8), -1))
        ->toThrow(RuntimeException::class, 'JPEG quality must be between 0 and 100.');
});

it('rejects undecodable image bytes', function () {
    expect(fn () => (new ImageCompressor)->forWeb('not-an-image'))
        ->toThrow(RuntimeException::class, 'Unable to decode image for web compression.');
});

it('rejects when canvas creation fails', function () {
    $compressor = new class extends ImageCompressor
    {
        protected function createCanvas(int $width, int $height): GdImage|false
        {
            return false;
        }
    };

    expect(fn () => $compressor->forWeb(createWebCompressionTestPng(8, 8)))
        ->toThrow(RuntimeException::class, 'Unable to create image canvas for compression.');
});

it('rejects when jpeg encoding fails', function () {
    $compressor = new class extends ImageCompressor
    {
        protected function writeJpeg(GdImage $canvas, int $quality): bool
        {
            return false;
        }
    };

    expect(fn () => $compressor->forWeb(createWebCompressionTestPng(8, 8)))
        ->toThrow(RuntimeException::class, 'Unable to encode image for the web.');
});

it('rejects when jpeg encoding yields empty contents', function () {
    $compressor = new class extends ImageCompressor
    {
        protected function attemptJpegEncode(GdImage $canvas, int $quality): array
        {
            return [true, ''];
        }
    };

    expect(fn () => $compressor->forWeb(createWebCompressionTestPng(8, 8)))
        ->toThrow(RuntimeException::class, 'Unable to encode image for the web.');
});

function createWebCompressionTestPng(int $width, int $height): string
{
    $image = imagecreatetruecolor($width, $height);

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $red = (int) (120 + 80 * sin($x / 40) + 20 * sin($y / 30));
            $green = (int) (100 + 70 * cos($x / 50) + 15 * cos($y / 25));
            $blue = (int) (90 + 60 * sin(($x + $y) / 60));
            $color = imagecolorallocate(
                $image,
                max(0, min(255, $red)),
                max(0, min(255, $green)),
                max(0, min(255, $blue)),
            );
            imagesetpixel($image, $x, $y, $color);
        }
    }

    ob_start();
    imagepng($image, null, 0);
    $binary = (string) ob_get_clean();
    imagedestroy($image);

    return $binary;
}
