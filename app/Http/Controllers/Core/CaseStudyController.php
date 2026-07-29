<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\Concerns\ProvidesServiceOptions;
use App\Http\Requests\Core\CaseStudyRequest;
use App\Models\CaseStudy;
use App\Services\MediaUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;

class CaseStudyController extends Controller
{
    use ProvidesServiceOptions;

    /**
     * Object storage directory for case study media.
     */
    protected const DIRECTORY = 'case-studies';

    /**
     * List the case studies shown on the portfolio.
     */
    public function index(): Response
    {
        $caseStudies = [];

        foreach (CaseStudy::with(['images', 'services'])->orderByDesc('created_at')->get() as $caseStudy) {
            $caseStudies[] = $this->props($caseStudy);
        }

        return Inertia::render('core/case-studies/Index', [
            'caseStudies' => $caseStudies,
        ]);
    }

    /**
     * Show the form to create a case study.
     */
    public function create(): Response
    {
        return Inertia::render('core/case-studies/Form', [
            'caseStudy' => null,
            'services' => $this->serviceOptions(),
        ]);
    }

    /**
     * Store a new case study with its services and gallery images.
     */
    public function store(CaseStudyRequest $request, MediaUploader $uploader): RedirectResponse
    {
        // The CaseStudyObserver sets the slug from the title.
        $caseStudy = CaseStudy::create($this->attributes($request, $uploader));

        $caseStudy->services()->sync($this->serviceIds($request));

        $this->storeImages($request, $caseStudy, $uploader);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Case study created.')]);

        return to_route('core.case-studies.index');
    }

    /**
     * Case studies are edited from the index; there is no detail page.
     */
    public function show(): never
    {
        abort(404);
    }

    /**
     * Show the form to edit a case study.
     */
    public function edit(CaseStudy $caseStudy): Response
    {
        $caseStudy->load(['images', 'services']);

        return Inertia::render('core/case-studies/Form', [
            'caseStudy' => $this->props($caseStudy),
            'services' => $this->serviceOptions(),
        ]);
    }

    /**
     * Update a case study, appending new images and dropping selected ones.
     */
    public function update(CaseStudyRequest $request, CaseStudy $caseStudy, MediaUploader $uploader): RedirectResponse
    {
        // The CaseStudyObserver regenerates the slug when the title changes.
        $caseStudy->update($this->attributes($request, $uploader));

        $caseStudy->services()->sync($this->serviceIds($request));

        $this->removeImages($request, $caseStudy);
        $this->storeImages($request, $caseStudy, $uploader);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Case study updated.')]);

        return to_route('core.case-studies.index');
    }

    /**
     * Soft delete a case study so it disappears from the portfolio.
     */
    public function destroy(CaseStudy $caseStudy): RedirectResponse
    {
        $caseStudy->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Case study deleted.')]);

        return to_route('core.case-studies.index');
    }

    /**
     * Text attributes with inline editor images moved to object storage.
     *
     * @return array<string, string>
     */
    protected function attributes(CaseStudyRequest $request, MediaUploader $uploader): array
    {
        /** @var array<string, string> $attributes */
        $attributes = $request->safe()->only([
            'title',
            'description',
            'client',
            'industry',
            'challenge',
            'content',
        ]);

        $attributes['content'] = $uploader->storeInlineImages($attributes['content'], self::DIRECTORY);

        return $attributes;
    }

    /**
     * The services delivered on the case study.
     *
     * @return list<string>
     */
    protected function serviceIds(CaseStudyRequest $request): array
    {
        $services = $request->validated('services');

        if (! is_array($services)) {
            return [];
        }

        return array_values($services);
    }

    /**
     * Upload the submitted gallery images and append them to the case study.
     */
    protected function storeImages(CaseStudyRequest $request, CaseStudy $caseStudy, MediaUploader $uploader): void
    {
        $files = $request->file('images');

        if (! is_array($files)) {
            return;
        }

        $alts = $request->validated('image_alts');
        $sortOrder = $this->nextSortOrder($caseStudy);

        foreach ($files as $index => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $caseStudy->images()->create([
                'url' => $uploader->store($file, self::DIRECTORY),
                'alt' => $this->alt($alts, $index, $caseStudy),
                'sort_order' => $sortOrder,
            ]);

            $sortOrder++;
        }
    }

    /**
     * Delete the gallery images the editor unchecked.
     */
    protected function removeImages(CaseStudyRequest $request, CaseStudy $caseStudy): void
    {
        $ids = $request->validated('remove_images');

        if (! is_array($ids)) {
            return;
        }

        foreach ($caseStudy->images()->whereIn('id', $ids)->get() as $image) {
            $image->delete();
        }
    }

    /**
     * The alt text submitted for an image, falling back to the title.
     */
    protected function alt(mixed $alts, int|string $index, CaseStudy $caseStudy): string
    {
        if (is_array($alts) && isset($alts[$index]) && is_string($alts[$index]) && filled($alts[$index])) {
            return $alts[$index];
        }

        return $caseStudy->title;
    }

    /**
     * The position for the next appended gallery image.
     */
    protected function nextSortOrder(CaseStudy $caseStudy): int
    {
        $current = $caseStudy->images()->max('sort_order');

        if ($current === null) {
            return 0;
        }

        return ((int) $current) + 1;
    }

    /**
     * Shape a case study for the admin pages.
     *
     * @return array{id: string, title: string, slug: string, description: string, client: string, industry: string, challenge: string, content: string, services: list<string>, images: list<array{id: string, url: string, alt: string}>}
     */
    protected function props(CaseStudy $caseStudy): array
    {
        $services = [];

        foreach ($caseStudy->services as $service) {
            $services[] = $service->id;
        }

        $images = [];

        foreach ($caseStudy->images as $image) {
            $images[] = [
                'id' => $image->id,
                'url' => $image->url,
                'alt' => $image->alt,
            ];
        }

        return [
            'id' => $caseStudy->id,
            'title' => $caseStudy->title,
            'slug' => $caseStudy->slug,
            'description' => $caseStudy->description,
            'client' => $caseStudy->client,
            'industry' => $caseStudy->industry,
            'challenge' => $caseStudy->challenge,
            'content' => $caseStudy->content,
            'services' => $services,
            'images' => $images,
        ];
    }
}
