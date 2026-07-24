<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ServiceLeadGenerationController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('service-lead-generation/ServiceLeadGeneration');
    }
}
