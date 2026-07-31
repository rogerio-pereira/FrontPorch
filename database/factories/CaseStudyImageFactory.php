<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CaseStudyImage>
 */
class CaseStudyImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'case_study_id' => CaseStudy::factory(),
            'url' => fake()->imageUrl(),
            'alt' => fake()->sentence(4),
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }

    /**
     * Indicate that the image is the cover of its case study.
     */
    public function cover(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'sort_order' => 0,
            ];
        });
    }
}
