<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\Concerns\ProvidesServiceOptions;
use App\Http\Requests\Core\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    use ProvidesServiceOptions;

    /**
     * List the FAQs of the home page and of every service landing.
     */
    public function index(): Response
    {
        $faqs = Faq::with('service')
                    ->orderBy('sort_order')
                    ->get();

        $props = [];

        foreach ($faqs as $faq) {
            $props[] = $this->props($faq);
        }

        return Inertia::render('core/faqs/Index', [
            'faqs' => $props,
        ]);
    }

    /**
     * Show the form to create a FAQ.
     */
    public function create(): Response
    {
        return Inertia::render('core/faqs/Form', [
            'faq' => null,
            'services' => $this->serviceOptions(),
        ]);
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
        return Inertia::render('core/faqs/Form', [
            'faq' => $this->props($faq),
            'services' => $this->serviceOptions(),
        ]);
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

    /**
     * Shape a FAQ for the admin pages.
     *
     * @return array{id: string, question: string, answer: string, sort_order: int, service_id: string|null, service: string|null}
     */
    protected function props(Faq $faq): array
    {
        $service = null;

        if ($faq->service !== null) {
            $service = $faq->service->title;
        }

        return [
            'id' => $faq->id,
            'question' => $faq->question,
            'answer' => $faq->answer,
            'sort_order' => $faq->sort_order,
            'service_id' => $faq->service_id,
            'service' => $service,
        ];
    }
}
