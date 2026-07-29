<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CaseStudy>
 */
class CaseStudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * The `slug` column is intentionally omitted: the CaseStudyObserver
     * derives it from the title.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(4),
            'description' => fake()->paragraph(2),
            'client' => fake()->company(),
            'industry' => fake()->words(2, true),
            'challenge' => fake()->paragraph(3),
            'content' => '<p>'.fake()->paragraph(6).'</p>',
        ];
    }

    /**
     * Attach a gallery to the case study; the first image becomes the cover.
     */
    public function withImages(int $count = 3): static
    {
        return $this->afterCreating(function (CaseStudy $caseStudy) use ($count): void {
            for ($sortOrder = 0; $sortOrder < $count; $sortOrder++) {
                CaseStudyImage::factory()
                    ->for($caseStudy)
                    ->create(['sort_order' => $sortOrder]);
            }
        });
    }

    /**
     * Indicate that the case study has been soft deleted.
     */
    public function softDeleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
        ]);
    }
}
