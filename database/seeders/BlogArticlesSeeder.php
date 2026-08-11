<?php

namespace Database\Seeders;

use App\Models\BlogArticle;
use Illuminate\Database\Seeder;

class BlogArticlesSeeder extends Seeder
{
    /**
     * Seed fake blog articles so the public blog does not look empty locally.
     */
    public function run(): void
    {
        BlogArticle::factory(30)
            ->create();
    }
}
