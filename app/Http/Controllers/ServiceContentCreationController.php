<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RendersServiceLanding;
use Inertia\Response;

class ServiceContentCreationController extends Controller
{
    use RendersServiceLanding;

    public function __invoke(): Response
    {
        return $this->renderServiceLanding(
            'content-creation',                                     // slug
            'service-content-creation/ServiceContentCreation',      // view
        );
    }
}
