<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RendersServiceLanding;
use Inertia\Response;

class ServiceWebsiteDesignAndDevelopmentController extends Controller
{
    use RendersServiceLanding;

    public function __invoke(): Response
    {
        return $this->renderServiceLanding(
            'website-design-and-development',
            'service-website-design-and-development/ServiceWebsiteDesignAndDevelopment',
        );
    }
}
