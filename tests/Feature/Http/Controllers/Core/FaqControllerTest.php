<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);
});

it('lists the faqs with the page they belong to', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    Faq::factory()
        ->forService($service)
        ->create([
            'question' => 'How many leads should I expect?',
            'sort_order' => 2,
        ]);

    Faq::factory()
        ->forHome()
        ->create([
            'question' => 'How much does this cost?',
            'sort_order' => 1,
        ]);

    $response = $this->get('/core/faqs');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
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
    Service::factory()
        ->create([
            'title' => 'Lead generation',
        ]);

    $response = $this->get('/core/faqs/create');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
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
    $response = $this->post(
        '/core/faqs',
        [
            'question' => 'What happens on a discovery call?',
            'answer' => 'It is a relaxed chat, not a sales interrogation.',
            'sort_order' => 9,
        ]
    );

    $response->assertRedirect('/core/faqs');

    $faq = Faq::where('question', 'What happens on a discovery call?')
                ->firstOrFail();

    $serviceId = $faq->service_id;
    expect($serviceId)->toBeNull();

    $sortOrder = $faq->sort_order;
    expect($sortOrder)->toBe(9);
});

it('creates a service faq', function () {
    $service = Service::factory()
                    ->create();

    $response = $this->post(
        '/core/faqs',
        [
            'question' => 'Do you run the ads for me?',
            'answer' => 'Yes, and we report on what they bring in.',
            'sort_order' => 1,
            'service_id' => $service->id,
        ]
    );

    $response->assertRedirect('/core/faqs');

    $faq = Faq::where('question', 'Do you run the ads for me?')
                ->firstOrFail();

    $serviceId = $faq->service_id;
    expect($serviceId)->toBe($service->id);
});

it('validates the faq payload', function () {
    $response = $this->post(
        '/core/faqs',
        [
            'question' => '',
            'answer' => '',
            'sort_order' => 'first',
            'service_id' => 'not-a-uuid',
        ]
    );

    $response->assertSessionHasErrors([
        'question',
        'answer',
        'sort_order',
        'service_id',
    ]);
});

it('shows the form to edit a faq', function () {
    $faq = Faq::factory()
                ->forHome()
                ->create([
                    'question' => 'How much does this cost?',
                ]);

    $url = "/core/faqs/{$faq->id}/edit";
    $response = $this->get($url);

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
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
    $faq = Faq::factory()
                ->forHome()
                ->create();

    $response = $this->put(
        "/core/faqs/{$faq->id}",
        [
            'question' => 'Where do you work with clients?',
            'answer' => 'We are based in Plant City, Florida.',
            'sort_order' => 3,
        ]
    );

    $response->assertRedirect('/core/faqs');

    $faq->refresh();

    $question = $faq->question;
    expect($question)->toBe('Where do you work with clients?');

    $sortOrder = $faq->sort_order;
    expect($sortOrder)->toBe(3);
});

it('soft deletes a faq', function () {
    $faq = Faq::factory()
                ->forHome()
                ->create();

    $url = "/core/faqs/{$faq->id}";
    $response = $this->delete($url);

    $response->assertRedirect('/core/faqs');

    $deleted = Faq::find($faq->id);
    $trashed = Faq::withTrashed()
                    ->find($faq->id);

    expect($deleted)->toBeNull();
    expect($trashed)->not->toBeNull();
});

it('has no detail page for faqs', function () {
    $faq = Faq::factory()
                ->forHome()
                ->create();

    $url = "/core/faqs/{$faq->id}";
    $response = $this->get($url);

    $response->assertNotFound();
});
