<?php

namespace App\Http\Controllers\Core\Concerns;

use App\Models\Service;

trait ProvidesServiceOptions
{
    /**
     * The services that can be picked on an admin form.
     *
     * @return list<array{id: string, title: string}>
     */
    protected function serviceOptions(): array
    {
        $services = Service::orderBy('sort_order')
                        ->get();

        $options = [];

        foreach ($services as $service) {
            $options[] = [
                'id' => $service->id,
                'title' => $service->title,
            ];
        }

        return $options;
    }
}
