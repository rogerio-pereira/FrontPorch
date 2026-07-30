<?php

use App\Models\Faq;
use App\Models\User;

it('shows the faqs admin screens to authenticated users', function (string $url, string $heading, ?string $submit) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $page = visit($url)
                ->waitForEvent('networkidle')
                ->assertSee($heading);

    if ($submit !== null) {
        $page->assertPresent($submit);
    }
})->with([
    'index' => ['/core/faqs', 'FAQs', null],
    'create' => ['/core/faqs/create', 'New FAQ', '@faq-submit'],
]);

it('shows the faqs edit form to authenticated users', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $faq = Faq::factory()
                ->create([
                    'service_id' => null,
                    'question' => 'How soon can we start?',
                ]);

    $url = "/core/faqs/{$faq->id}/edit";

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee('Edit FAQ')
        ->assertPresent('@faq-submit');
});

it('creates a faq from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    visit('/core/faqs/create')
        ->waitForEvent('networkidle')
        ->type('question', 'How soon can we start?')
        ->type('answer', 'As soon as we finish a short discovery call.')
        ->click('@faq-submit')
        ->waitForText('How soon can we start?')
        ->assertPathIs('/core/faqs');

    $faqExists = Faq::where('question', 'How soon can we start?')
                    ->exists();

    expect($faqExists)
        ->toBeTrue();
});

it('edits a faq from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $faq = Faq::factory()
                ->create([
                    'service_id' => null,
                    'question' => 'Original question?',
                    'answer' => 'Original answer.',
                    'sort_order' => 1,
                ]);

    visit("/core/faqs/{$faq->id}/edit")
        ->waitForEvent('networkidle')
        ->type('question', 'Updated question?')
        ->click('@faq-submit')
        ->waitForText('Updated question?')
        ->assertPathIs('/core/faqs');

    $question = $faq->refresh()
                    ->question;

    expect($question)->toBe('Updated question?');
});

it('deletes a faq from the admin index', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $faq = Faq::factory()
                ->create([
                    'service_id' => null,
                    'question' => 'Delete this FAQ?',
                ]);

    visit('/core/faqs')
        ->waitForEvent('networkidle')
        ->assertSee('Delete this FAQ?')
        ->click("@faq-delete-{$faq->id}")
        ->waitForText('No FAQs yet.')
        ->assertDontSee('Delete this FAQ?');

    $deleted = Faq::find($faq->id);

    expect($deleted)->toBeNull();
});
