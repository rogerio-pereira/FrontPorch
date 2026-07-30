<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Model events stay enabled so the observers derive slugs exactly as
     * they do through the admin panel (except where a seeder opts out).
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServicesSeeder::class,
            FaqHomeSeeder::class,
            TestimonialsSeeder::class,
        ]);
    }
}
