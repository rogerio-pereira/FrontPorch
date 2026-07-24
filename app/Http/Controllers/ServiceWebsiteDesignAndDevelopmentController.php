<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ServiceWebsiteDesignAndDevelopmentController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('service-website-design-and-development/ServiceWebsiteDesignAndDevelopment');
    }
}
