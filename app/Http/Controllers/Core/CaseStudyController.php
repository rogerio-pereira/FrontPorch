<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\CaseStudyRequest;
use App\Models\CaseStudy;
use App\Models\Service;
use App\Services\MediaUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;

class CaseStudyController extends Controller
{
    /**
     * Object storage directory for case study media.
     */
    protected const DIRECTORY = 'case-studies';

    /**
     * List the case studies shown on the portfolio.
     */
    public function index(): Response
    {
        $caseStudies = CaseStudy::with(['images', 'services'])
                        ->orderByDesc('created_at')
                        ->get();

        return Inertia::render('core/case-studies/Index', compact('caseStudies'));
    }

    /**
     * Show the form to create a case study.
     */
    public function create(): Response
    {
        $services = Service::orderBy('sort_order')
                        ->pluck('title', 'id');

        return Inertia::render('core/case-studies/Form', [
            'caseStudy' => null,
            'services' => $services,
        ]);
    }

    /**
     * Store a new case study with its services and gallery images.
     */
    public function store(CaseStudyRequest $request, MediaUploader $uploader): RedirectResponse
    {
        // The CaseStudyObserver sets the slug from the title.
        $attributes = $this->attributes($request);
        $serviceIds = $this->serviceIds($request);

        $caseStudy = CaseStudy::create($attributes);

        $caseStudy->services()->sync($serviceIds);

        $this->storeImages($request, $caseStudy, $uploader);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Case study created.'),
            ]
        );

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

        $services = Service::orderBy('sort_order')
                        ->pluck('title', 'id');

        return Inertia::render('core/case-studies/Form', [
            'caseStudy' => $caseStudy,
            'services' => $services,
        ]);
    }

    /**
     * Update a case study, appending new images and dropping selected ones.
     */
    public function update(CaseStudyRequest $request, CaseStudy $caseStudy, MediaUploader $uploader): RedirectResponse
    {
        // The CaseStudyObserver regenerates the slug when the title changes.
        $attributes = $this->attributes($request);
        $serviceIds = $this->serviceIds($request);

        $caseStudy->update($attributes);

        $caseStudy->services()->sync($serviceIds);

        $this->removeImages($request, $caseStudy);
        $this->storeImages($request, $caseStudy, $uploader);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Case study updated.'),
            ]
        );

        return to_route('core.case-studies.index');
    }

    /**
     * Soft delete a case study so it disappears from the portfolio.
     */
    public function destroy(CaseStudy $caseStudy): RedirectResponse
    {
        $caseStudy->delete();

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Case study deleted.'),
            ]
        );

        return to_route('core.case-studies.index');
    }

    /**
     * Text attributes for create and update.
     *
     * Inline images are uploaded through the media helper and inserted as
     * URLs in the editor; content is stored as submitted.
     *
     * @return array<string, string>
     */
    protected function attributes(CaseStudyRequest $request): array
    {
        $data = $request->validated();

        return [
            'title' => $data['title'],
            'description' => $data['description'],
            'client' => $data['client'],
            'industry' => $data['industry'],
            'challenge' => $data['challenge'],
            'content' => $data['content'],
        ];
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

            $url = $uploader->store($file, self::DIRECTORY);
            $alt = $this->alt($alts, $index, $caseStudy);

            $caseStudy->images()->create([
                'url' => $url,
                'alt' => $alt,
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

        $images = $caseStudy->images()
                    ->whereIn('id', $ids)
                    ->get();

        foreach ($images as $image) {
            $image->delete();
        }
    }

    /**
     * The alt text submitted for an image, falling back to the title.
     */
    protected function alt(mixed $alts, int|string $index, CaseStudy $caseStudy): string
    {
        if (
            is_array($alts) &&
            isset($alts[$index]) &&
            is_string($alts[$index]) &&
            filled($alts[$index])
        ) {
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
}
