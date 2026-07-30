<?php

namespace App\Observers;

use App\Models\Service;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ServiceObserver
{
    /**
     * Handle the Service "creating" event.
     */
    public function creating(Service $service): void
    {
        $service->slug = $this->slugFromTitle($service->title);
    }

    /**
     * Handle the Service "updating" event.
     */
    public function updating(Service $service): void
    {
        if (! $service->isDirty('title')) {
            return;
        }

        $service->slug = $this->slugFromTitle($service->title);
    }

    /**
     * Derive a URL slug from the service title.
     */
    protected function slugFromTitle(string $title): string
    {
        $slug = Str::slug($title);

        if ($slug === '') {
            throw new InvalidArgumentException('A service title must produce a non-empty slug.');
        }

        return $slug;
    }
}
