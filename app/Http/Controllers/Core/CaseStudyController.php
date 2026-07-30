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
        $data = $request->validated();

        $caseStudy = CaseStudy::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'client' => $data['client'],
            'industry' => $data['industry'],
            'challenge' => $data['challenge'],
            'content' => $data['content'],
        ]);

        $services = $data['services'] ?? [];
        $caseStudy->services()->sync($services);

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
        $data = $request->validated();

        $caseStudy->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'client' => $data['client'],
            'industry' => $data['industry'],
            'challenge' => $data['challenge'],
            'content' => $data['content'],
        ]);

        $services = $data['services'] ?? [];
        $caseStudy->services()->sync($services);

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
     * Upload the submitted gallery images and append them to the case study.
     */
    protected function storeImages(CaseStudyRequest $request, CaseStudy $caseStudy, MediaUploader $uploader): void
    {
        $files = $request->file('images');

        if (! is_array($files)) {
            return;
        }

        $sortOrder = $caseStudy->images()->max('sort_order');

        if ($sortOrder === null) {
            $sortOrder = 0;
        } else {
            $sortOrder = ((int) $sortOrder) + 1;
        }

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $url = $uploader->store($file, self::DIRECTORY);

            $caseStudy->images()->create([
                'url' => $url,
                'alt' => $caseStudy->title,
                'sort_order' => $sortOrder,
            ]);

            $sortOrder++;
        }
    }

    /**
     * Delete the gallery images the editor unchecked.
     *
     * Storage objects are left in place for now: MediaUploader only returns
     * URLs, not storage keys, so file cleanup stays a follow-up.
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
}
