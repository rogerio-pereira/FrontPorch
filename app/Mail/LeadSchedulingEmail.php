<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadSchedulingEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @param  array{name: string, email: string, phone: string|null, website: string|null}  $lead
     */
    public function __construct(
        public array $lead,
        public string $calendarUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Book your discovery call with '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.lead-scheduling',
            with: [
                'lead' => $this->lead,
                'calendarUrl' => $this->calendarUrl,
            ],
        );
    }
}
