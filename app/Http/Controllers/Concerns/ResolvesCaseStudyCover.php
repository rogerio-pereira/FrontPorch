<?php

namespace App\Http\Controllers\Concerns;

use App\Models\CaseStudy;

trait ResolvesCaseStudyCover
{
    /**
     * Cover used while a case study has no gallery image.
     */
    protected const PLACEHOLDER_IMAGE = '/images/home/portfolio-a.png';

    /**
     * The first gallery image of a case study, or a placeholder.
     */
    protected function coverImage(CaseStudy $caseStudy): string
    {
        $cover = $caseStudy->images->first();

        if ($cover === null) {
            return self::PLACEHOLDER_IMAGE;
        }

        return $cover->url;
    }

    /**
     * The alt text of the cover image, falling back to the title.
     */
    protected function coverAlt(CaseStudy $caseStudy): string
    {
        $cover = $caseStudy->images->first();

        if ($cover === null) {
            return $caseStudy->title;
        }

        return $cover->alt;
    }

    /**
     * The service titles delivered on a case study, as a single line.
     */
    protected function serviceLine(CaseStudy $caseStudy): string
    {
        $titles = [];

        foreach ($caseStudy->services as $service) {
            $titles[] = $service->title;
        }

        return implode(', ', $titles);
    }
}
