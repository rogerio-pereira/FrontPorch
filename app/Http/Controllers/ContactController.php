<?php

namespace App\Http\Controllers;

use App\Events\ContactLeadSubmitted;
use App\Http\Requests\ContactRequest;
use App\Models\Service;
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

        if (empty($lead['website'])) {
            $lead['website'] = null;
        }

        $serviceSlugs = $lead['services'] ?? [];

        if (! is_array($serviceSlugs) || $serviceSlugs === []) {
            $lead['services'] = [];
        } else {
            $lead['services'] = Service::whereIn('slug', $serviceSlugs)
                                    ->orderBy('sort_order')
                                    ->pluck('title')
                                    ->all();
        }

        /*
         * Listeners are registered manually in App\Providers\EventServiceProvider:
         *      SendLeadEmail: notifies CONTACT_EMAIL
         *      SendLeadSchedulingEmail: emails the lead a Calendar booking link
         *      SendLeadSlackNotification: optional Slack ping
         */
        ContactLeadSubmitted::dispatch($lead);

        $toastMessage = __('Thanks — we received your message and will be in touch soon.');
        $calendarUrl = config('site.calendar_url');

        if (is_string($calendarUrl) && $calendarUrl !== '') {
            $toastMessage = __('Thanks — check your email for the link to book your discovery call.');
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $toastMessage,
        ]);

        return back();
    }
}
