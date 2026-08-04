<?php

use App\Mail\LeadSchedulingEmail;
use Illuminate\Mail\Mailables\Content;

it('builds markdown content with lead and calendar url', function () {
    $lead = [
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => '(813) 555-0100',
        'website' => 'https://example.com',
    ];
    $calendarUrl = 'https://calendar.example.com/book';

    $mail = new LeadSchedulingEmail($lead, $calendarUrl);

    $content = $mail->content();

    expect($content)->toBeInstanceOf(Content::class);
    expect($content->markdown)->toBe('emails.lead-scheduling');
    expect($content->with)->toBe([
        'lead' => $lead,
        'calendarUrl' => $calendarUrl,
    ]);
});

it('renders the lead scheduling markdown', function () {
    $mail = new LeadSchedulingEmail([
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => null,
        'website' => 'https://example.com',
    ], 'https://calendar.example.com/book');

    $html = $mail->render();

    expect($html)->toContain('Alex Rivera');
    expect($html)->toContain('https://calendar.example.com/book');
    expect($html)->toContain('Book a discovery call');
});
