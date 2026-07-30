<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\FaqRequest;
use App\Models\Faq;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    /**
     * List the FAQs of the home page and of every service landing.
     */
    public function index(): Response
    {
        $faqs = Faq::with('service')
                    ->orderBy('sort_order')
                    ->get();

        return Inertia::render('core/faqs/Index', compact('faqs'));
    }

    /**
     * Show the form to create a FAQ.
     */
    public function create(): Response
    {
        $faq = null;

        $services = Service::orderBy('sort_order')
                        ->pluck('title', 'id');

        return Inertia::render('core/faqs/Form', compact('faq', 'services'));
    }

    /**
     * Store a new FAQ; leaving the service empty attaches it to the home page.
     */
    public function store(FaqRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Faq::create($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('FAQ created.'),
            ]
        );

        return to_route('core.faqs.index');
    }

    /**
     * FAQs are edited from the index; there is no detail page.
     */
    public function show(): never
    {
        abort(404);
    }

    /**
     * Show the form to edit a FAQ.
     */
    public function edit(Faq $faq): Response
    {
        $services = Service::orderBy('sort_order')
                        ->pluck('title', 'id');

        return Inertia::render('core/faqs/Form', compact('faq', 'services'));
    }

    /**
     * Update a FAQ.
     */
    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $data = $request->validated();

        $faq->update($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('FAQ updated.'),
            ]
        );

        return to_route('core.faqs.index');
    }

    /**
     * Soft delete a FAQ.
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('FAQ deleted.'),
            ]
        );

        return to_route('core.faqs.index');
    }
}
