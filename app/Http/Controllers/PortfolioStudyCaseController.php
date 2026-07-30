<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioStudyCaseController extends Controller
{
    /**
     * Show a case study; soft-deleted ones are not found by the route binding.
     */
    public function __invoke(CaseStudy $caseStudy): Response
    {
        $caseStudy->load(['images', 'services']);

        return Inertia::render('portfolio-study-case/PortfolioStudyCase', compact('caseStudy'));
    }
}
