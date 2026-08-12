<?php

use App\Mail\LeadEmail;
use Illuminate\Mail\Mailables\Content;

it('builds markdown content with lead and phone display', function () {
    $lead = [
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => '(813) 555-0100',
        'website' => 'https://example.com',
        'services' => 'Lead generation, Email marketing',
    ];

    $mail = new LeadEmail($lead);

    $content = $mail->content();

    expect($content)->toBeInstanceOf(Content::class);
    expect($content->markdown)->toBe('emails.lead-notification');
    expect($content->with)->toBe([
        'lead' => $lead,
        'phoneDisplay' => '(813) 555-0100',
        'websiteDisplay' => 'https://example.com',
    ]);
});

it('renders the lead notification markdown', function () {
    $mail = new LeadEmail([
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => null,
        'website' => 'https://example.com',
        'services' => 'Lead generation',
    ]);

    $html = $mail->render();

    expect($html)->toContain('Alex Rivera');
    expect($html)->toContain('alex@example.com');
    expect($html)->toContain('Lead generation');
    expect($html)->toContain('https://example.com');
    expect($html)->toContain('(not provided)');
    expect(strpos($html, 'Services:'))->toBeLessThan(strpos($html, 'Website:'));
    expect(strpos($html, 'Website:'))->toBeLessThan(strpos($html, 'Phone:'));
});

it('renders not provided when website is missing', function () {
    $mail = new LeadEmail([
        'name' => 'Alex Rivera',
        'email' => 'alex@example.com',
        'phone' => '(813) 555-0100',
        'website' => null,
        'services' => 'Lead generation',
    ]);

    $html = $mail->render();

    expect($html)->toContain('(813) 555-0100');
    expect($html)->toContain('(not provided)');
    expect($mail->websiteDisplay)->toBe('(not provided)');
    expect($html)->toContain('Lead generation');
});
