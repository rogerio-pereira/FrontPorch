<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Model events stay enabled so the observers derive slugs and article
     * authors exactly as they do through the admin panel (except where a
     * seeder opts out).
     */
    public function run(): void
    {
        /*
         * =============================================================================================================
         * REAL DATA
         * =============================================================================================================
         */
        $this->call([
            ServicesSeeder::class,
            FaqHomeSeeder::class,
            UserSeeder::class,
        ]);

        /*
         * =============================================================================================================
         * FAKE DATA
         * =============================================================================================================
         */
        $currentEnv = config('app.env');
        if (
            $currentEnv === 'local' ||
            $currentEnv === 'testing'
        ) {
            $this->call([
                UserLocalSeeder::class,
                TestimonialsSeeder::class,
                CaseStudiesSeeder::class,
                BlogArticlesSeeder::class,
            ]);
        }
    }
}
