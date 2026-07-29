<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\Concerns\ProvidesServiceOptions;
use App\Http\Requests\Core\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialController extends Controller
{
    use ProvidesServiceOptions;

    /**
     * List the testimonials sampled on the home page and service landings.
     */
    public function index(): Response
    {
        $testimonials = [];

        foreach (Testimonial::with('service')->orderBy('person')->get() as $testimonial) {
            $testimonials[] = $this->props($testimonial);
        }

        return Inertia::render('core/testimonials/Index', [
            'testimonials' => $testimonials,
        ]);
    }

    /**
     * Show the form to create a testimonial.
     */
    public function create(): Response
    {
        return Inertia::render('core/testimonials/Form', [
            'testimonial' => null,
            'services' => $this->serviceOptions(),
        ]);
    }

    /**
     * Store a new testimonial.
     */
    public function store(TestimonialRequest $request): RedirectResponse
    {
        Testimonial::create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Testimonial created.')]);

        return to_route('core.testimonials.index');
    }

    /**
     * Testimonials are edited from the index; there is no detail page.
     */
    public function show(): never
    {
        abort(404);
    }

    /**
     * Show the form to edit a testimonial.
     */
    public function edit(Testimonial $testimonial): Response
    {
        return Inertia::render('core/testimonials/Form', [
            'testimonial' => $this->props($testimonial),
            'services' => $this->serviceOptions(),
        ]);
    }

    /**
     * Update a testimonial.
     */
    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Testimonial updated.')]);

        return to_route('core.testimonials.index');
    }

    /**
     * Soft delete a testimonial.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Testimonial deleted.')]);

        return to_route('core.testimonials.index');
    }

    /**
     * Shape a testimonial for the admin pages.
     *
     * @return array{id: string, person: string, testimonial: string, service_id: string, service: string|null}
     */
    protected function props(Testimonial $testimonial): array
    {
        $service = null;

        if ($testimonial->service !== null) {
            $service = $testimonial->service->title;
        }

        return [
            'id' => $testimonial->id,
            'person' => $testimonial->person,
            'testimonial' => $testimonial->testimonial,
            'service_id' => $testimonial->service_id,
            'service' => $service,
        ];
    }
}
