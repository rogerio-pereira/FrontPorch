<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $phoneDisplay;

    public string $websiteDisplay;

    /**
     * @param  array{name: string, email: string, phone: string|null, website: string|null}  $lead
     */
    public function __construct(
        public array $lead,
    ) {
        if (empty($this->lead['phone'])) {
            $this->phoneDisplay = '(not provided)';
        } else {
            $this->phoneDisplay = $this->lead['phone'];
        }

        if (empty($this->lead['website'])) {
            $this->websiteDisplay = '(not provided)';
        } else {
            $this->websiteDisplay = $this->lead['website'];
        }
    }

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
                'phoneDisplay' => $this->phoneDisplay,
                'websiteDisplay' => $this->websiteDisplay,
            ],
        );
    }
}
