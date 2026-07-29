<?php

use App\Models\Faq;
use App\Models\User;

it('creates a faq from the admin form', function () {
    $this->actingAs(User::factory()->create());

    visit('/core/faqs/create')
        ->waitForEvent('networkidle')
        ->type('question', 'How soon can we start?')
        ->type('answer', 'As soon as we finish a short discovery call.')
        ->click('@faq-submit')
        ->waitForText('How soon can we start?')
        ->assertPathIs('/core/faqs');

    expect(Faq::where('question', 'How soon can we start?')->exists())->toBeTrue();
});

it('edits a faq from the admin form', function () {
    $this->actingAs(User::factory()->create());

    $faq = Faq::factory()->forHome()->create([
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

    expect($faq->refresh()->question)->toBe('Updated question?');
});

it('deletes a faq from the admin index', function () {
    $this->actingAs(User::factory()->create());

    $faq = Faq::factory()->forHome()->create(['question' => 'Delete this FAQ?']);

    visit('/core/faqs')
        ->waitForEvent('networkidle')
        ->assertSee('Delete this FAQ?')
        ->click("@faq-delete-{$faq->id}")
        ->waitForText('No FAQs yet.')
        ->assertDontSee('Delete this FAQ?');

    expect(Faq::find($faq->id))->toBeNull();
});
