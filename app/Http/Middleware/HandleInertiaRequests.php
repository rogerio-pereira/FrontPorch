<?php

namespace App\Http\Middleware;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'site' => [
                'footerContactEmail' => config('site.footer_contact_email'),
                'calendarUrl' => config('site.calendar_url'),
            ],
            'servicesNav' => $this->servicesNav(),
        ];
    }

    /**
     * The service catalog used by the public navigation.
     *
     * @return list<array{slug: string, title: string}>
     */
    protected function servicesNav(): array
    {
        $services = [];

        foreach (Service::orderBy('sort_order')->get(['slug', 'title']) as $service) {
            $services[] = [
                'slug' => $service->slug,
                'title' => $service->title,
            ];
        }

        return $services;
    }
}
