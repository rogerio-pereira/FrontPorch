<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesCaseStudyCover;
use App\Models\CaseStudy;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    use ResolvesCaseStudyCover;

    /**
     * Case studies per page on the public portfolio.
     */
    protected const PER_PAGE = 15;

    public function __invoke(): Response
    {
        $caseStudies = CaseStudy::with(['images', 'services'])
                        ->orderByDesc('created_at')
                        ->paginate(self::PER_PAGE);

        $items = [];

        foreach ($caseStudies as $caseStudy) {
            $href = route('portfolio.study-case', $caseStudy->slug, false);

            $items[] = [
                'id' => $caseStudy->id,
                'title' => $caseStudy->title,
                'excerpt' => $caseStudy->description,
                'client' => $caseStudy->client,
                'service' => $this->serviceLine($caseStudy),
                'coverImage' => $this->coverImage($caseStudy),
                'href' => $href,
            ];
        }

        $pagination = [
            'currentPage' => $caseStudies->currentPage(),
            'lastPage' => $caseStudies->lastPage(),
            'previousPageUrl' => $caseStudies->previousPageUrl(),
            'nextPageUrl' => $caseStudies->nextPageUrl(),
        ];

        return Inertia::render('portfolio/Portfolio', [
            'items' => $items,
            'pagination' => $pagination,
        ]);
    }
}
