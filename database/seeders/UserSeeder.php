<?php

namespace Database\Seeders;

use App\Domain\User\Models\User;

class USerSeeder extends DatabaseSeeder
{
    /**
     * Seed the application's database with admin data.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
