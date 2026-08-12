<?php

namespace App\Providers;

use App\Events\ContactLeadSubmitted;
use App\Listeners\SendLeadEmail;
use App\Listeners\SendLeadSchedulingEmail;
use App\Listeners\SendLeadSlackNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Explicit event → listener map (auto-discovery is disabled).
     *
     * Comment out or remove a listener here to disable it.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ContactLeadSubmitted::class => [
            SendLeadEmail::class, // notifies CONTACT_EMAIL
            SendLeadSlackNotification::class, // optional Slack ping
            // SendLeadSchedulingEmail::class, // emails the lead a Calendar booking link
        ],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * Email verification is already wired by the framework EventServiceProvider.
     */
    protected function configureEmailVerification(): void
    {
        //
    }
}
