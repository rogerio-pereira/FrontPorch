<?php

use App\Models\CaseStudy;
use App\Models\Service;
use App\Models\User;

it('creates a case study from the admin form', function () {
    $this->actingAs(User::factory()->create());

    $service = Service::factory()->create(['title' => 'Lead generation']);

    visit('/core/case-studies/create')
        ->waitForEvent('networkidle')
        ->type('title', 'From missed calls to booked jobs')
        ->type('description', 'Together we rebuilt their digital front porch.')
        ->type('client', 'Cypress & Oak Home Services')
        ->type('industry', 'Home services')
        ->type('challenge', 'Good leads cooled off before anyone could reply.')
        ->type('content', '<p>We started with a discovery conversation.</p>')
        ->check("@case-study-service-{$service->id}")
        ->click('@case-study-submit')
        ->waitForText('From missed calls to booked jobs')
        ->assertPathIs('/core/case-studies');

    $caseStudy = CaseStudy::where('slug', 'from-missed-calls-to-booked-jobs')->first();

    expect($caseStudy)->not->toBeNull();
    expect($caseStudy->services)->toHaveCount(1);
});

it('edits a case study from the admin form', function () {
    $this->actingAs(User::factory()->create());

    $caseStudy = CaseStudy::factory()->create([
        'title' => 'Original case study',
        'description' => 'Original description.',
        'client' => 'Original client',
        'industry' => 'Original industry',
        'challenge' => 'Original challenge.',
        'content' => '<p>Original content.</p>',
    ]);

    visit("/core/case-studies/{$caseStudy->id}/edit")
        ->waitForEvent('networkidle')
        ->type('title', 'Updated case study')
        ->click('@case-study-submit')
        ->waitForText('Updated case study')
        ->assertPathIs('/core/case-studies');

    expect($caseStudy->refresh()->slug)->toBe('updated-case-study');
});

it('deletes a case study from the admin index', function () {
    $this->actingAs(User::factory()->create());

    $caseStudy = CaseStudy::factory()->create(['title' => 'Delete this case study']);

    visit('/core/case-studies')
        ->waitForEvent('networkidle')
        ->assertSee('Delete this case study')
        ->click("@case-study-delete-{$caseStudy->id}")
        ->waitForText('No case studies yet.')
        ->assertDontSee('Delete this case study');

    expect(CaseStudy::find($caseStudy->id))->toBeNull();
});
