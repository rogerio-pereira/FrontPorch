<?php

use App\Http\Middleware\ServePublicAssets;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

it('serves existing public files through the testing middleware', function () {
    $relativePath = 'serve-public-assets-test.txt';
    $absolutePath = public_path($relativePath);

    file_put_contents($absolutePath, 'frontporch-public-asset');

    try {
        $response = $this->get('/'.$relativePath);

        $response->assertOk();
        expect($response->streamedContent())->toBe('frontporch-public-asset');
    } finally {
        if (is_file($absolutePath)) {
            unlink($absolutePath);
        }
    }
});

it('does not serve path traversal attempts outside public', function () {
    $this->get('/../.env')
        ->assertNotFound();
});

it('passes through missing public files to the router', function () {
    $this->get('/definitely-missing-static-asset-'.uniqid('', true).'.txt')
        ->assertNotFound();
});

it('passes through when the application is not in the testing environment', function () {
    $previousEnvironment = app()->environment();
    app()->instance('env', 'local');

    try {
        $middleware = new ServePublicAssets;
        $request = Request::create('/robots.txt', 'GET');
        $passedThrough = false;

        $response = $middleware->handle($request, function (Request $request) use (&$passedThrough): Response {
            $passedThrough = true;

            return response('next-handler');
        });

        expect($passedThrough)->toBeTrue();
        expect($response->getContent())->toBe('next-handler');
        expect($response)->not->toBeInstanceOf(BinaryFileResponse::class);
    } finally {
        app()->instance('env', $previousEnvironment);
    }
});

it('passes through when the public root cannot be resolved', function () {
    $previousPublicPath = public_path();
    app()->usePublicPath('/nonexistent-public-root-'.uniqid('', true));

    try {
        $middleware = new ServePublicAssets;
        $request = Request::create('/robots.txt', 'GET');
        $passedThrough = false;

        $response = $middleware->handle($request, function (Request $request) use (&$passedThrough): Response {
            $passedThrough = true;

            return response('missing-public-root');
        });

        expect($passedThrough)->toBeTrue();
        expect($response->getContent())->toBe('missing-public-root');
        expect($response)->not->toBeInstanceOf(BinaryFileResponse::class);
    } finally {
        app()->usePublicPath($previousPublicPath);
    }
});

it('passes through when the resolved public path is a directory', function () {
    $middleware = new ServePublicAssets;
    $request = Request::create('/fonts', 'GET');
    $passedThrough = false;

    $response = $middleware->handle($request, function (Request $request) use (&$passedThrough): Response {
        $passedThrough = true;

        return response('directory-passthrough');
    });

    expect($passedThrough)->toBeTrue();
    expect($response->getContent())->toBe('directory-passthrough');
    expect($response)->not->toBeInstanceOf(BinaryFileResponse::class);
});

it('passes through the application root path', function () {
    $middleware = new ServePublicAssets;
    $request = Request::create('/', 'GET');
    $passedThrough = false;

    $response = $middleware->handle($request, function (Request $request) use (&$passedThrough): Response {
        $passedThrough = true;

        return response('root-passthrough');
    });

    expect($passedThrough)->toBeTrue();
    expect($response->getContent())->toBe('root-passthrough');
});
