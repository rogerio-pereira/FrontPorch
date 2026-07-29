<?php

namespace App\Observers;

use App\Models\CaseStudy;
use App\Support\UniqueSlug;

class CaseStudyObserver
{
    /**
     * Handle the CaseStudy "creating" event.
     */
    public function creating(CaseStudy $caseStudy): void
    {
        $caseStudy->slug = UniqueSlug::uniqueSlug($caseStudy->title, CaseStudy::class);
    }

    /**
     * Handle the CaseStudy "updating" event.
     */
    public function updating(CaseStudy $caseStudy): void
    {
        if (! $caseStudy->isDirty('title')) {
            return;
        }

        $caseStudy->slug = UniqueSlug::uniqueSlug($caseStudy->title, CaseStudy::class, $caseStudy->id);
    }
}
