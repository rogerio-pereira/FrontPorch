<?php

namespace App\Observers;

use App\Models\Service;
use App\Support\UniqueSlug;

class ServiceObserver
{
    /**
     * Handle the Service "creating" event.
     */
    public function creating(Service $service): void
    {
        $service->slug = UniqueSlug::uniqueSlug($service->title, Service::class);
    }

    /**
     * Handle the Service "updating" event.
     */
    public function updating(Service $service): void
    {
        if (! $service->isDirty('title')) {
            return;
        }

        $service->slug = UniqueSlug::uniqueSlug($service->title, Service::class, $service->id);
    }
}
