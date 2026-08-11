<?php

use App\Models\CaseStudy;
use App\Models\Service;
use App\Models\User;

beforeEach()->flaky();

it('shows the case studies admin screens to authenticated users', function (string $url, string $heading, ?string $submit) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    Service::factory()
        ->create([
            'title' => 'Lead generation',
        ]);

    $page = visit($url)
                ->waitForEvent('networkidle')
                ->assertSee($heading);

    if ($submit !== null) {
        $page->assertPresent($submit);
    }
})->with([
    'index' => ['/core/case-studies', 'Case studies', null],
    'create' => ['/core/case-studies/create', 'New case study', '@case-study-submit'],
]);

it('shows the case studies edit form to authenticated users', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                    ]);

    $url = "/core/case-studies/{$caseStudy->id}/edit";

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee('Edit case study')
        ->assertPresent('@case-study-submit');
});

it('shows the case studies create form with the rich text editor', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    Service::factory()
        ->create([
            'title' => 'Lead generation',
        ]);

    visit('/core/case-studies/create')
        ->waitForEvent('networkidle')
        ->assertSee('New case study')
        ->assertPresent('@rich-text-editor')
        ->assertPresent('@rich-text-toolbar')
        ->assertPresent('@case-study-submit');
});

it('creates a case study from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    $page = visit('/core/case-studies/create')
                ->waitForEvent('networkidle')
                ->type('title', 'From missed calls to booked jobs')
                ->type('description', 'Together we rebuilt their digital front porch.')
                ->type('client', 'Cypress & Oak Home Services')
                ->type('industry', 'Home services')
                ->type('challenge', 'Good leads cooled off before anyone could reply.')
                ->assertPresent('@rich-text-editor');

    $page->script(<<<'JS'
        (() => {
            const input = document.querySelector('[data-test="rich-text-content-input"]');
            if (input === null) {
                throw new Error('Rich text content input was not found.');
            }
            input.value = '<p>We started with a discovery conversation.</p>';
        })()
    JS);

    $page->check("@case-study-service-{$service->id}")
        ->click('@case-study-submit')
        ->waitForText('From missed calls to booked jobs')
        ->assertPathIs('/core/case-studies');

    $caseStudy = CaseStudy::where('slug', 'from-missed-calls-to-booked-jobs')
                    ->first();

    expect($caseStudy)->not->toBeNull();

    $servicesCount = $caseStudy->services->count();

    expect($servicesCount)->toBe(1);
});

it('edits a case study from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $caseStudy = CaseStudy::factory()
                    ->create([
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

    $slug = $caseStudy->refresh()
                ->slug;

    expect($slug)->toBe('updated-case-study');
});

it('deletes a case study from the admin index', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'Delete this case study',
                    ]);

    visit('/core/case-studies')
        ->waitForEvent('networkidle')
        ->assertSee('Delete this case study')
        ->click("@case-study-delete-{$caseStudy->id}")
        ->waitForText('No case studies yet.')
        ->assertDontSee('Delete this case study');

    $deleted = CaseStudy::find($caseStudy->id);

    expect($deleted)->toBeNull();
});
