<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sentence = fake()->sentence(8);
        $question = rtrim($sentence, '.');
        $question = $question.'?';

        return [
            'service_id' => Service::factory(),
            'question' => $question,
            'answer' => fake()->paragraph(3),
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }

    /**
     * Indicate that the FAQ belongs to the home page instead of a service.
     */
    public function forHome(): static
    {
        return $this->state([
            'service_id' => null,
        ]);
    }

    /**
     * Indicate that the FAQ belongs to the given service landing page.
     */
    public function forService(Service $service): static
    {
        return $this->state([
            'service_id' => $service->id,
        ]);
    }
}
