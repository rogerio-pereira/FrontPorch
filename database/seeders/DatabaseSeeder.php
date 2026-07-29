<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Model events stay enabled so the observers derive slugs exactly as
     * they do through the admin panel.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if ($user === null) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            ServicesSeeder::class,
        ]);
    }
}
