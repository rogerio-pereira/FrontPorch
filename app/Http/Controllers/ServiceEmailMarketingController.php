<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RendersServiceLanding;
use Inertia\Response;

class ServiceEmailMarketingController extends Controller
{
    use RendersServiceLanding;

    public function __invoke(): Response
    {
        return $this->renderServiceLanding(
            'email-marketing',
            'service-email-marketing/ServiceEmailMarketing',
        );
    }
}
