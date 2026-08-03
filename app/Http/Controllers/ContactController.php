<?php

namespace App\Http\Controllers;

use App\Events\ContactLeadSubmitted;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        $lead = $request->validated();

        if (empty($lead['phone'])) {
            $lead['phone'] = null;
        }

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
