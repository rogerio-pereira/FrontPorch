<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('lists the faqs with the page they belong to', function () {
    $service = Service::factory()->create(['title' => 'Lead generation']);

    Faq::factory()->forService($service)->create([
        'question' => 'How many leads should I expect?',
        'sort_order' => 2,
    ]);

    Faq::factory()->forHome()->create([
        'question' => 'How much does this cost?',
        'sort_order' => 1,
    ]);

    $this->get('/core/faqs')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/faqs/Index')
            ->has('faqs', 2)
            ->has('faqs.0', fn (Assert $faq) => $faq
                ->where('question', 'How much does this cost?')
                ->where('service', null)
                ->where('service_id', null)
                ->where('sort_order', 1)
                ->has('id')
                ->has('answer')
            )
            ->has('faqs.1', fn (Assert $faq) => $faq
                ->where('service', 'Lead generation')
                ->where('service_id', $service->id)
                ->etc()
            )
        );
});

it('shows the form to create a faq with the service options', function () {
    Service::factory()->create(['title' => 'Lead generation']);

    $this->get('/core/faqs/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/faqs/Form')
            ->where('faq', null)
            ->has('services', 1)
            ->has('services.0', fn (Assert $service) => $service
                ->where('title', 'Lead generation')
                ->has('id')
            )
        );
});

it('creates a home faq when no service is picked', function () {
    $this->post('/core/faqs', [
        'question' => 'What happens on a discovery call?',
        'answer' => 'It is a relaxed chat, not a sales interrogation.',
        'sort_order' => 9,
    ])->assertRedirect('/core/faqs');

    $faq = Faq::where('question', 'What happens on a discovery call?')->firstOrFail();

    expect($faq->service_id)->toBeNull();
    expect($faq->sort_order)->toBe(9);
});

it('creates a service faq', function () {
    $service = Service::factory()->create();

    $this->post('/core/faqs', [
        'question' => 'Do you run the ads for me?',
        'answer' => 'Yes, and we report on what they bring in.',
        'sort_order' => 1,
        'service_id' => $service->id,
    ])->assertRedirect('/core/faqs');

    expect(Faq::where('question', 'Do you run the ads for me?')->firstOrFail()->service_id)->toBe($service->id);
});

it('validates the faq payload', function () {
    $this->post('/core/faqs', [
        'question' => '',
        'answer' => '',
        'sort_order' => 'first',
        'service_id' => 'not-a-uuid',
    ])->assertSessionHasErrors(['question', 'answer', 'sort_order', 'service_id']);
});

it('shows the form to edit a faq', function () {
    $faq = Faq::factory()->forHome()->create(['question' => 'How much does this cost?']);

    $this->get("/core/faqs/{$faq->id}/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/faqs/Form')
            ->has('faq', fn (Assert $props) => $props
                ->where('id', $faq->id)
                ->where('question', 'How much does this cost?')
                ->where('service', null)
                ->etc()
            )
            ->has('services')
        );
});

it('updates a faq', function () {
    $faq = Faq::factory()->forHome()->create();

    $this->put("/core/faqs/{$faq->id}", [
        'question' => 'Where do you work with clients?',
        'answer' => 'We are based in Plant City, Florida.',
        'sort_order' => 3,
    ])->assertRedirect('/core/faqs');

    $faq->refresh();

    expect($faq->question)->toBe('Where do you work with clients?');
    expect($faq->sort_order)->toBe(3);
});

it('soft deletes a faq', function () {
    $faq = Faq::factory()->forHome()->create();

    $this->delete("/core/faqs/{$faq->id}")->assertRedirect('/core/faqs');

    expect(Faq::find($faq->id))->toBeNull();
    expect(Faq::withTrashed()->find($faq->id))->not->toBeNull();
});

it('has no detail page for faqs', function () {
    $faq = Faq::factory()->forHome()->create();

    $this->get("/core/faqs/{$faq->id}")->assertNotFound();
});
