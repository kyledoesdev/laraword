<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Kyle Evangelisto',
            'email' => 'kyledoesdev@gmail.com',
            'password' => 'password',
            'timezone' => 'America/New_York',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0',
            'user_platform' => 'web',
            'email_verified_at' => now(),
            'remember_token' => str()->random(64),
            'is_dev' => true,
        ]);

        $this->call(WordSeeder::class);
        $this->call(LeaderboardSeeder::class);
    }
}
