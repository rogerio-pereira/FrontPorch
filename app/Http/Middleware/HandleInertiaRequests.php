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
        $parentShare = parent::share($request);

        $servicesNav = Service::orderBy('sort_order')
                        ->get(['slug', 'title']);

        return [
            ...$parentShare,
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'site' => [
                'contactEmail' => config('site.contact_email'),
                'turnstileSiteKey' => config('services.turnstile.key'),
                'turnstileTesting' => app()->environment('testing'),
                'googleAnalyticsId' => $this->optionalSiteConfigString('site.google_analytics_id'),
                'metaPixelId' => $this->optionalSiteConfigString('site.meta_pixel_id'),
            ],
            'servicesNav' => $servicesNav,
        ];
    }

    /**
     * Return a non-empty config string, or null when unset.
     */
    private function optionalSiteConfigString(string $key): ?string
    {
        $value = config($key);

        if (! is_string($value)) {
            return null;
        }

        if ($value === '') {
            return null;
        }

        return $value;
    }
}
