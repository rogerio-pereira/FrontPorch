<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * List the service catalog in the order it appears on the site.
     */
    public function index(): Response
    {
        $services = Service::orderBy('sort_order')
                        ->get();

        $props = [];

        foreach ($services as $service) {
            $props[] = $this->props($service);
        }

        return Inertia::render('core/services/Index', [
            'services' => $props,
        ]);
    }

    /**
     * Show the form to create a service.
     */
    public function create(): Response
    {
        return Inertia::render('core/services/Form', [
            'service' => null,
        ]);
    }

    /**
     * Store a new service.
     */
    public function store(ServiceRequest $request): RedirectResponse
    {
        // The ServiceObserver sets the slug from the title.
        $data = $request->validated();

        Service::create($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Service created.'),
            ]
        );

        return to_route('core.services.index');
    }

    /**
     * Services are edited from the index; there is no detail page.
     */
    public function show(): never
    {
        abort(404);
    }

    /**
     * Show the form to edit a service.
     */
    public function edit(Service $service): Response
    {
        return Inertia::render('core/services/Form', [
            'service' => $this->props($service),
        ]);
    }

    /**
     * Update a service.
     */
    public function update(ServiceRequest $request, Service $service): RedirectResponse
    {
        // The ServiceObserver regenerates the slug when the title changes.
        $data = $request->validated();

        $service->update($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Service updated.'),
            ]
        );

        return to_route('core.services.index');
    }

    /**
     * Soft delete a service so it disappears from the public site.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('Service deleted.'),
            ]
        );

        return to_route('core.services.index');
    }

    /**
     * Shape a service for the admin pages.
     *
     * @return array{id: string, title: string, description: string, slug: string, sort_order: int}
     */
    protected function props(Service $service): array
    {
        return [
            'id' => $service->id,
            'title' => $service->title,
            'description' => $service->description,
            'slug' => $service->slug,
            'sort_order' => $service->sort_order,
        ];
    }
}
