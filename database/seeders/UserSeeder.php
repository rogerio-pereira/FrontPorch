<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed the default application users.
     *
     * Pre-hashed passwords are inserted via the query builder so the Eloquent
     * "hashed" cast does not reject bcrypt cost mismatches (e.g. tests use
     * BCRYPT_ROUNDS=4 while these hashes were generated with cost 12).
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Rogerio Pereira',
                'email' => 'rodu.pereira@gmail.com',
                'password' => '$2y$12$cmP2pvkQuYnz1SoXnnIYc.6b8HoJ/v510pm6HYRv./d8hg4rZ/oEy',
            ],
            [
                'name' => 'Sarah Jessica Xavier Pereira',
                'email' => 'saahjessicaxp@gmail.com',
                'password' => '$2y$12$7eC6j0PlU5GbRkYxgMZ2futB7ATNTadIxTT/us1P38PBpF0upn7O.',
            ],
        ];

        foreach ($users as $user) {
            $email = $user['email'];

            $existingUser = User::where('email', $email)
                ->first();

            if ($existingUser !== null) {
                continue;
            }

            $now = now();

            DB::table('users')->insert([
                'id' => (string) Str::uuid(),
                'name' => $user['name'],
                'email' => $email,
                'password' => $user['password'],
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
