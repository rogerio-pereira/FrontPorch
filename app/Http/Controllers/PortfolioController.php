<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    /**
     * Case studies per page on the public portfolio.
     */
    protected const PER_PAGE = 15;

    public function __invoke(): Response
    {
        $caseStudies = CaseStudy::with(['images', 'services'])
                           ->orderByDesc('created_at')
                           ->paginate(self::PER_PAGE);

        return Inertia::render('portfolio/Portfolio', compact('caseStudies'));
    }
}
