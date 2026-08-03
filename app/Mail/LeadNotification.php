<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @param  array{name: string, email: string, phone: string|null}  $lead
     */
    public function __construct(
        public array $lead,
    ) {}

    public function envelope(): Envelope
    {
        $subject = 'New website lead from '.$this->lead['name'];

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.lead-notification',
            with: [
                'lead' => $this->lead,
            ],
        );
    }
}
