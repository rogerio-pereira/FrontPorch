<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ServiceBusinessAutomationsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('service-business-automations/ServiceBusinessAutomations');
    }
}
