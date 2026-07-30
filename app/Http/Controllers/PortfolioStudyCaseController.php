<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesCaseStudyCover;
use App\Models\CaseStudy;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioStudyCaseController extends Controller
{
    use ResolvesCaseStudyCover;

    /**
     * Show a case study; soft-deleted ones are not found by the route binding.
     */
    public function __invoke(CaseStudy $caseStudy): Response
    {
        $caseStudy->load(['images', 'services']);

        $serviceLine = $this->serviceLine($caseStudy);
        $coverImage = $this->coverImage($caseStudy);
        $coverAlt = $this->coverAlt($caseStudy);
        $galleryImages = $this->galleryImages($caseStudy);

        $payload = [
            'title' => $caseStudy->title,
            'description' => $caseStudy->description,
            'client' => $caseStudy->client,
            'industry' => $caseStudy->industry,
            'service' => $serviceLine,
            'coverImage' => $coverImage,
            'coverAlt' => $coverAlt,
            'challenge' => $caseStudy->challenge,
            'content' => $caseStudy->content,
            'galleryImages' => $galleryImages,
        ];

        return Inertia::render('portfolio-study-case/PortfolioStudyCase', [
            'caseStudy' => $payload,
        ]);
    }

    /**
     * The gallery images shown in the carousel; the cover is skipped.
     *
     * @return list<array{src: string, alt: string}>
     */
    private function galleryImages(CaseStudy $caseStudy): array
    {
        $images = [];

        $gallery = $caseStudy->images
                        ->skip(1);

        foreach ($gallery as $image) {
            $images[] = [
                'src' => $image->url,
                'alt' => $image->alt,
            ];
        }

        return $images;
    }
}
