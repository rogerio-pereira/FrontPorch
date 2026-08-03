<?php

namespace App\Http\Controllers;

use App\Events\ContactLeadSubmitted;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $lead = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'website' => $data['website'],
        ];

        /*
         * Dispatch event (will call two listeners)
         *      SendLeadEmail: notifies CONTACT_EMAIL
         *      SendLeadSlackNotification: optional Slack ping
         */
        ContactLeadSubmitted::dispatch($lead);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Thanks — we received your message and will be in touch soon.'),
        ]);

        return back();
    }
}
