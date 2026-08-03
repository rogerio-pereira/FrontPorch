<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Services\LeadSubmissionService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function store(
        StoreContactRequest $request,
        LeadSubmissionService $leadSubmissionService,
    ): RedirectResponse {
        $data = $request->validated();

        $phone = $data['phone'] ?? null;

        if (! is_string($phone) || trim($phone) === '') {
            $phone = null;
        }

        $lead = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $phone,
        ];

        $leadSubmissionService->submit($lead);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Thanks — we received your message and will be in touch soon.'),
        ]);

        return back();
    }
}
