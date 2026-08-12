<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactLeadSubmitted
{
    use Dispatchable;
    use SerializesModels;

    /**
     * @param  array{name: string, email: string, phone: string|null, website: string|null}  $lead
     */
    public function __construct(
        public array $lead,
    ) {}
}
