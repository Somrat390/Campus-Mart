<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
   {
    // 1. Run the University Seeder first so universities exist
    $this->call(UniversitySeeder::class);

    // 2. Now create the test user with a valid university_id
    \App\Models\User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'university_id' => 1, // Connects to the first university created
        'student_id_image' => 'id_cards/default.png', // Add a dummy path
    ]);
    }
}
