<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RendersServiceLanding;
use Inertia\Response;

class ServiceCustomSoftwareDevelopmentController extends Controller
{
    use RendersServiceLanding;

    public function __invoke(): Response
    {
        return $this->renderServiceLanding(
            'custom-software-development',                                          // slug
            'service-custom-software-development/ServiceCustomSoftwareDevelopment', // view
        );
    }
}
