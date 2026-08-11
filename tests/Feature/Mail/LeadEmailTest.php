<?php

use App\Mail\LeadEmail;
use Illuminate\Mail\Mailables\Content;

it('builds markdown content with lead and phone display', function () {
    $lead = [
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => '(813) 555-0100',
        'website' => 'https://example.com',
    ];

    $mail = new LeadEmail($lead);

    $content = $mail->content();

    expect($content)->toBeInstanceOf(Content::class);
    expect($content->markdown)->toBe('emails.lead-notification');
    expect($content->with)->toBe([
        'lead' => $lead,
        'phoneDisplay' => '(813) 555-0100',
    ]);
});

it('renders the lead notification markdown', function () {
    $mail = new LeadEmail([
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => null,
        'website' => 'https://example.com',
    ]);

    $html = $mail->render();

    expect($html)->toContain('Alex Rivera');
    expect($html)->toContain('alex@example.com');
    expect($html)->toContain('(not provided)');
    expect($html)->toContain('https://example.com');
});
