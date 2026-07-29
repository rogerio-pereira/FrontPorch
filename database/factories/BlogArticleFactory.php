<?php

namespace Database\Factories;

use App\Models\BlogArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BlogArticle>
 */
class BlogArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * The `slug` and `published_by` columns are intentionally omitted: the
     * BlogArticleObserver sets both on create.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(5),
            'description' => fake()->sentence(15),
            'category' => fake()->randomElement(['Branding', 'Marketing', 'Web Design', 'Strategy', 'Content']),
            'content' => '<p>'.fake()->paragraph(8).'</p>',
            'image' => 'https://images.example.com/blog/'.fake()->uuid().'.jpg',
        ];
    }

    /**
     * Indicate that the article has been soft deleted.
     */
    public function softDeleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
        ]);
    }
}
