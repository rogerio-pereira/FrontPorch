<?php

use App\Http\Controllers\Core\MediaUploadController;
use App\Http\Requests\Core\MediaUploadRequest;
use App\Models\User;
use App\Services\MediaUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

beforeEach(function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    Storage::fake();
});

it('stores an uploaded image and returns its public url', function () {
    $file = UploadedFile::fake()
                ->image('inline.png');

    $response = $this->post('/core/media', [
        'directory' => 'blog',
        'file' => $file,
    ]);

    $response->assertOk();
    $response->assertJsonStructure(['url']);

    $url = $response->json('url');

    expect($url)->toBeString()
        ->and($url)->not->toBeEmpty();
});

it('rejects uploads outside the allowed directories', function () {
    $file = UploadedFile::fake()
                ->image('inline.png');

    $response = $this->post('/core/media', [
        'directory' => 'secrets',
        'file' => $file,
    ]);

    $response->assertSessionHasErrors('directory');
});

it('rejects guests from uploading media', function () {
    auth()->logout();

    $file = UploadedFile::fake()
                ->image('inline.png');

    $response = $this->post('/core/media', [
        'directory' => 'blog',
        'file' => $file,
    ]);

    $response->assertRedirect();
});

it('requires an image file', function () {
    $response = $this->post('/core/media', [
        'directory' => 'case-studies',
    ]);

    $response->assertSessionHasErrors('file');
});

it('aborts when the uploaded file is missing after validation', function () {
    $request = Mockery::mock(MediaUploadRequest::class);
    $request->shouldReceive('file')
        ->with('file')
        ->once()
        ->andReturn(null);
    $request->shouldReceive('validated')
        ->never();

    $uploader = Mockery::mock(MediaUploader::class);
    $uploader->shouldNotReceive('store');

    try {
        app(MediaUploadController::class)->store($request, $uploader);
        $this->fail('Expected store to abort with 422.');
    } catch (HttpException $exception) {
        $statusCode = $exception->getStatusCode();
        expect($statusCode)->toBe(422);
    }
});
