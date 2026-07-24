<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ServiceEmailMarketingController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('service-email-marketing/ServiceEmailMarketing');
    }
}
