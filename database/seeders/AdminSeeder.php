<?php

namespace Database\Seeders;

use App\Domain\Admin\Models\Admin;

class AdminSeeder extends DatabaseSeeder
{
    /**
     * Seed the application's database with admin data.
     */
    public function run(): void
    {
        Admin::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
    }
}
