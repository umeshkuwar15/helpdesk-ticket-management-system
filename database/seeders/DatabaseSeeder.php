<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the database with default admin, user and categories.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );

        $defaultCategories = [
            'Technical Issue',
            'Account Issue',
            'Software Issue',
            'Hardware Issue',
            'Other',
        ];

        foreach ($defaultCategories as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }
    }
}
