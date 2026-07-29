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
    $this->actingAs(User::factory()->create());

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
    $caseStudy = CaseStudy::factory()->create(['title' => 'From missed calls to booked jobs']);
    CaseStudyImage::factory()->for($caseStudy)->cover()->create();

    $this->get('/core/case-studies')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/case-studies/Index')
            ->has('caseStudies', 1)
            ->has('caseStudies.0', fn (Assert $props) => $props
                ->where('id', $caseStudy->id)
                ->where('title', 'From missed calls to booked jobs')
                ->where('slug', 'from-missed-calls-to-booked-jobs')
                ->has('images', 1)
                ->etc()
            )
        );
});

it('shows the form to create a case study', function () {
    Service::factory()->create();

    $this->get('/core/case-studies/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/case-studies/Form')
            ->where('caseStudy', null)
            ->has('services', 1)
        );
});

it('creates a case study with services and gallery images', function () {
    $service = Service::factory()->create();

    $this->post('/core/case-studies', [
        ...caseStudyPayload(),
        'services' => [$service->id],
        'images' => [
            UploadedFile::fake()->create('cover.jpg', 12),
            UploadedFile::fake()->create('process.jpg', 12),
        ],
        'image_alts' => ['Homepage overview', ''],
    ])->assertRedirect('/core/case-studies');

    $caseStudy = CaseStudy::where('slug', 'from-missed-calls-to-booked-jobs')->firstOrFail();

    expect($caseStudy->services)->toHaveCount(1);
    expect($caseStudy->images)->toHaveCount(2);
    expect($caseStudy->images->first()->alt)->toBe('Homepage overview');
    expect($caseStudy->images->last()->alt)->toBe('From missed calls to booked jobs');
    expect($caseStudy->images->first()->sort_order)->toBe(0);
    expect(Storage::allFiles('case-studies'))->toHaveCount(2);
});

it('moves inline content images to object storage', function () {
    $payload = base64_encode('inline-image');

    $this->post('/core/case-studies', [
        ...caseStudyPayload(),
        'content' => '<p>Before</p><img src="data:image/png;base64,'.$payload.'">',
    ])->assertRedirect('/core/case-studies');

    $caseStudy = CaseStudy::where('slug', 'from-missed-calls-to-booked-jobs')->firstOrFail();

    expect($caseStudy->content)->not->toContain('data:image');
    expect(Storage::allFiles('case-studies'))->toHaveCount(1);
});

it('validates the case study payload', function () {
    $this->post('/core/case-studies', [
        'title' => '',
        'description' => '',
        'client' => '',
        'industry' => '',
        'challenge' => '',
        'content' => '',
        'services' => ['not-a-uuid'],
    ])->assertSessionHasErrors(['title', 'description', 'client', 'industry', 'challenge', 'content', 'services.0']);
});

it('shows the form to edit a case study', function () {
    $service = Service::factory()->create();
    $caseStudy = CaseStudy::factory()->create(['title' => 'From missed calls to booked jobs']);
    $caseStudy->services()->attach($service);
    $image = CaseStudyImage::factory()->for($caseStudy)->cover()->create();

    $this->get("/core/case-studies/{$caseStudy->id}/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/case-studies/Form')
            ->has('caseStudy', fn (Assert $props) => $props
                ->where('id', $caseStudy->id)
                ->where('services', [$service->id])
                ->has('images', 1)
                ->has('images.0', fn (Assert $imageProps) => $imageProps
                    ->where('id', $image->id)
                    ->has('url')
                    ->has('alt')
                )
                ->etc()
            )
            ->has('services', 1)
        );
});

it('updates a case study, appending and removing images', function () {
    $caseStudy = CaseStudy::factory()->create(['title' => 'From missed calls to booked jobs']);
    $removed = CaseStudyImage::factory()->for($caseStudy)->cover()->create();
    $kept = CaseStudyImage::factory()->for($caseStudy)->create(['sort_order' => 1]);
    $service = Service::factory()->create();

    $this->put("/core/case-studies/{$caseStudy->id}", [
        ...caseStudyPayload(),
        'title' => 'From missed calls to booked weeks',
        'services' => [$service->id],
        'remove_images' => [$removed->id],
        'images' => [UploadedFile::fake()->create('gallery.jpg', 12)],
    ])->assertRedirect('/core/case-studies');

    $caseStudy->refresh()->load(['images', 'services']);

    expect($caseStudy->slug)->toBe('from-missed-calls-to-booked-weeks');
    expect($caseStudy->services)->toHaveCount(1);
    expect($caseStudy->images->pluck('id')->all())->toContain($kept->id);
    expect($caseStudy->images->pluck('id')->all())->not->toContain($removed->id);
    expect($caseStudy->images)->toHaveCount(2);
    expect($caseStudy->images->last()->sort_order)->toBe(2);
});

it('leaves gallery images when remove_images is omitted', function () {
    $caseStudy = CaseStudy::factory()->create();
    CaseStudyImage::factory()->for($caseStudy)->cover()->create();

    $this->put("/core/case-studies/{$caseStudy->id}", caseStudyPayload())
        ->assertRedirect('/core/case-studies');

    expect($caseStudy->refresh()->images)->toHaveCount(1);
});

it('skips gallery entries that are not uploaded files', function () {
    $caseStudy = CaseStudy::factory()->create();

    $request = Mockery::mock(CaseStudyRequest::class);
    $request->shouldReceive('file')->with('images')->andReturn([
        'not-a-file',
        UploadedFile::fake()->create('cover.jpg', 12),
    ]);
    $request->shouldReceive('validated')->with('image_alts')->andReturn(null);

    $method = new ReflectionMethod(CaseStudyController::class, 'storeImages');
    $method->invoke(app(CaseStudyController::class), $request, $caseStudy, app(MediaUploader::class));

    expect($caseStudy->images()->count())->toBe(1);
    expect(Storage::allFiles('case-studies'))->toHaveCount(1);
});

it('soft deletes a case study', function () {
    $caseStudy = CaseStudy::factory()->create();

    $this->delete("/core/case-studies/{$caseStudy->id}")->assertRedirect('/core/case-studies');

    expect(CaseStudy::find($caseStudy->id))->toBeNull();
    expect(CaseStudy::withTrashed()->find($caseStudy->id))->not->toBeNull();
});

it('has no detail page for case studies', function () {
    $caseStudy = CaseStudy::factory()->create();

    $this->get("/core/case-studies/{$caseStudy->id}")->assertNotFound();
});
