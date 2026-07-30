<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\TestimonialRequest;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialController extends Controller
{
    /**
     * List the testimonials sampled on the home page and service landings.
     */
    public function index(): Response
    {
        $testimonials = Testimonial::with('service')
                        ->orderBy('person')
                        ->get();

        return Inertia::render('core/testimonials/Index', compact('testimonials'));
    }

    /**
     * Show the form to create a testimonial.
     */
    public function create(): Response
    {
        $testimonial = null;

        $services = Service::orderBy('sort_order')
                        ->pluck('title', 'id');

        return Inertia::render('core/testimonials/Form', compact('testimonial', 'services'));
    }

    /**
     * Store a new testimonial.
     */
    public function store(TestimonialRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Testimonial::create($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Testimonial created.'),
            ]
        );

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
        $services = Service::orderBy('sort_order')
                        ->pluck('title', 'id');

        return Inertia::render('core/testimonials/Form', compact('testimonial', 'services'));
    }

    /**
     * Update a testimonial.
     */
    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validated();

        $testimonial->update($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Testimonial updated.'),
            ]
        );

        return to_route('core.testimonials.index');
    }

    /**
     * Soft delete a testimonial.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Testimonial deleted.'),
            ]
        );

        return to_route('core.testimonials.index');
    }
}
