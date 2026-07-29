<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person' => fake()->name(),
            'testimonial' => fake()->paragraph(3),
            'service_id' => Service::factory(),
        ];
    }

    /**
     * Indicate that the testimonial refers to the given service.
     */
    public function forService(Service $service): static
    {
        return $this->state(fn (array $attributes) => [
            'service_id' => $service->id,
        ]);
    }
}
