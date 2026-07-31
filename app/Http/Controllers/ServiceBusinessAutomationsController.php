<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RendersServiceLanding;
use Inertia\Response;

class ServiceBusinessAutomationsController extends Controller
{
    use RendersServiceLanding;

    public function __invoke(): Response
    {
        return $this->renderServiceLanding(
            'business-automations',                                    // slug
            'service-business-automations/ServiceBusinessAutomations', // view
        );
    }
}
