<?php

use App\Http\Controllers\Core\CaseStudyController;
use App\Http\Requests\Core\CaseStudyRequest;
use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Service;
use App\Models\User;
use App\Services\MediaUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    Storage::fake();
});

/**
 * @return array<string, string>
 */
function caseStudyPayload(): array
{
    return [
        'title' => 'From missed calls to booked jobs',
        'description' => 'Together we rebuilt their digital front porch.',
        'client' => 'Cypress & Oak Home Services',
        'industry' => 'Home services',
        'challenge' => 'Good leads cooled off before anyone could reply.',
        'content' => '<p>We started with a discovery conversation.</p>',
    ];
}

it('lists the case studies', function () {
    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                    ]);

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->cover()
        ->create();

    $response = $this->get('/core/case-studies');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/case-studies/Index')
        ->has('caseStudies', 1)
        ->has('caseStudies.0', fn (Assert $props) => $props
            ->where('id', $caseStudy->id)
            ->where('title', 'From missed calls to booked jobs')
            ->where('slug', 'from-missed-calls-to-booked-jobs')
            ->has('images', 1)
            ->etc() // allows extra props (timestamps, etc.) without asserting each one.
        )
    );
});

it('shows the form to create a case study', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    $response = $this->get('/core/case-studies/create');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/case-studies/Form')
        ->where('caseStudy', null)
        ->has('services', 1)
        ->where("services.{$service->id}", 'Lead generation')
    );
});

it('creates a case study with services and gallery images', function () {
    $service = Service::factory()
                    ->create();

    $response = $this->post(
        '/core/case-studies',
        [
            ...caseStudyPayload(),
            'services' => [$service->id],
            'images' => [
                UploadedFile::fake()->create('cover.jpg', 12),
                UploadedFile::fake()->create('process.jpg', 12),
            ],
            'image_alts' => ['Homepage overview', ''],
        ]
    );

    $response->assertRedirect('/core/case-studies');

    $caseStudy = CaseStudy::where('slug', 'from-missed-calls-to-booked-jobs')
                    ->firstOrFail();

    $servicesCount = $caseStudy->services->count();
    $imagesCount = $caseStudy->images->count();
    $firstAlt = $caseStudy->images->first()->alt;
    $lastAlt = $caseStudy->images->last()->alt;
    $firstSortOrder = $caseStudy->images->first()->sort_order;
    $storedFiles = Storage::allFiles('case-studies');

    expect($servicesCount)->toBe(1);
    expect($imagesCount)->toBe(2);
    expect($firstAlt)->toBe('Homepage overview');
    expect($lastAlt)->toBe('From missed calls to booked jobs');
    expect($firstSortOrder)->toBe(0);
    expect($storedFiles)->toHaveCount(2);
});

it('validates the case study payload', function () {
    $response = $this->post(
        '/core/case-studies',
        [
            'title' => '',
            'description' => '',
            'client' => '',
            'industry' => '',
            'challenge' => '',
            'content' => '',
            'services' => ['not-a-uuid'],
        ]
    );

    $response->assertSessionHasErrors([
        'title',
        'description',
        'client',
        'industry',
        'challenge',
        'content',
        'services.0',
    ]);
});

it('rejects a duplicate case study title', function () {
    CaseStudy::factory()
        ->create([
            'title' => 'From missed calls to booked jobs',
        ]);

    $response = $this->post(
        '/core/case-studies',
        caseStudyPayload()
    );

    $response->assertSessionHasErrors([
        'title',
    ]);
});

it('shows the form to edit a case study', function () {
    $service = Service::factory()
                    ->create();

    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                    ]);

    $caseStudy->services()->attach($service);

    $image = CaseStudyImage::factory()
                ->for($caseStudy)
                ->cover()
                ->create();

    $url = "/core/case-studies/{$caseStudy->id}/edit";
    $response = $this->get($url);

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/case-studies/Form')
        ->has('caseStudy', fn (Assert $props) => $props
            ->where('id', $caseStudy->id)
            ->has('services', 1)
            ->has('services.0', fn (Assert $attached) => $attached
                ->where('id', $service->id)
                ->etc()
            )
            ->has('images', 1)
            ->has('images.0', fn (Assert $imageProps) => $imageProps
                ->where('id', $image->id)
                ->has('url')
                ->has('alt')
                ->etc()
            )
            ->etc() // allows extra props (timestamps, etc.) without asserting each one.
        )
        ->has('services', 1)
    );
});

it('updates a case study, appending and removing images', function () {
    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                    ]);

    $removed = CaseStudyImage::factory()
                    ->for($caseStudy)
                    ->cover()
                    ->create();

    $kept = CaseStudyImage::factory()
                ->for($caseStudy)
                ->create([
                    'sort_order' => 1,
                ]);

    $service = Service::factory()
                    ->create();

    $url = "/core/case-studies/{$caseStudy->id}";
    $response = $this->put(
        $url,
        [
            ...caseStudyPayload(),
            'title' => 'From missed calls to booked weeks',
            'services' => [$service->id],
            'remove_images' => [$removed->id],
            'images' => [UploadedFile::fake()->create('gallery.jpg', 12)],
        ]
    );

    $response->assertRedirect('/core/case-studies');

    $caseStudy->refresh()->load(['images', 'services']);

    $slug = $caseStudy->slug;
    $servicesCount = $caseStudy->services->count();
    $imageIds = $caseStudy->images->pluck('id')->all();
    $imagesCount = $caseStudy->images->count();
    $lastSortOrder = $caseStudy->images->last()->sort_order;

    expect($slug)->toBe('from-missed-calls-to-booked-weeks');
    expect($servicesCount)->toBe(1);
    expect($imageIds)->toContain($kept->id);
    expect($imageIds)->not->toContain($removed->id);
    expect($imagesCount)->toBe(2);
    expect($lastSortOrder)->toBe(2);
});

it('leaves gallery images when remove_images is omitted', function () {
    $caseStudy = CaseStudy::factory()
                    ->create();

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->cover()
        ->create();

    $url = "/core/case-studies/{$caseStudy->id}";
    $response = $this->put($url, caseStudyPayload());

    $response->assertRedirect('/core/case-studies');

    $imagesCount = $caseStudy->refresh()->images->count();

    expect($imagesCount)->toBe(1);
});

it('skips gallery entries that are not uploaded files', function () {
    $caseStudy = CaseStudy::factory()
                    ->create();

    $request = Mockery::mock(CaseStudyRequest::class);
    $request->shouldReceive('file')
        ->with('images')
        ->andReturn([
            'not-a-file',
            UploadedFile::fake()->create('cover.jpg', 12),
        ]);
    $request->shouldReceive('validated')
        ->with('image_alts')
        ->andReturn(null);

    $method = new ReflectionMethod(CaseStudyController::class, 'storeImages');
    $method->invoke(
        app(CaseStudyController::class),
        $request,
        $caseStudy,
        app(MediaUploader::class)
    );

    $imagesCount = $caseStudy->images()->count();
    $storedFiles = Storage::allFiles('case-studies');

    expect($imagesCount)->toBe(1);
    expect($storedFiles)->toHaveCount(1);
});

it('soft deletes a case study', function () {
    $caseStudy = CaseStudy::factory()
                    ->create();

    $url = "/core/case-studies/{$caseStudy->id}";
    $response = $this->delete($url);

    $response->assertRedirect('/core/case-studies');

    $deleted = CaseStudy::find($caseStudy->id);
    $trashed = CaseStudy::withTrashed()
                    ->find($caseStudy->id);

    expect($deleted)->toBeNull();
    expect($trashed)->not->toBeNull();
});

it('has no detail page for case studies', function () {
    $caseStudy = CaseStudy::factory()
                    ->create();

    $url = "/core/case-studies/{$caseStudy->id}";
    $response = $this->get($url);

    $response->assertNotFound();
});
