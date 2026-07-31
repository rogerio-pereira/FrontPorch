<?php

namespace App\Observers;

use App\Models\CaseStudy;
use Illuminate\Support\Str;
use InvalidArgumentException;

class CaseStudyObserver
{
    /**
     * Handle the CaseStudy "creating" event.
     */
    public function creating(CaseStudy $caseStudy): void
    {
        $caseStudy->slug = $this->slugFromTitle($caseStudy->title);
    }

    /**
     * Handle the CaseStudy "updating" event.
     */
    public function updating(CaseStudy $caseStudy): void
    {
        if (! $caseStudy->isDirty('title')) {
            return;
        }

        $caseStudy->slug = $this->slugFromTitle($caseStudy->title);
    }

    /**
     * Derive a URL slug from the case study title.
     */
    protected function slugFromTitle(string $title): string
    {
        $slug = Str::slug($title);

        if ($slug === '') {
            throw new InvalidArgumentException('A case study title must produce a non-empty slug.');
        }

        return $slug;
    }
}
