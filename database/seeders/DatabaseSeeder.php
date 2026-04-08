<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $admin = User::updateOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345'),
        ]);

        $admin->assignRole('admin');

        $donor = User::updateOrCreate([
            'email' => 'user@gmail.com',
        ], [
            'name' => 'Demo User',
            'email' => 'user@gmail.com',
            'role' => 'donor',
            'password' => Hash::make('12345'),
        ]);

        $donor->assignRole('donor');
    }
}
