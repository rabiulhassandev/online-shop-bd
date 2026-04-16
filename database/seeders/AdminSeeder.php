<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the default admin account.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@katua.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'),
            ]
        );
    }
}
