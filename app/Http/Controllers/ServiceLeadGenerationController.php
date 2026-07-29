<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RendersServiceLanding;
use Inertia\Response;

class ServiceLeadGenerationController extends Controller
{
    use RendersServiceLanding;

    public function __invoke(): Response
    {
        return $this->renderServiceLanding(
            'lead-generation',
            'service-lead-generation/ServiceLeadGeneration',
        );
    }
}
