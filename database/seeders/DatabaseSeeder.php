<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\DifficultyLevelSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(DifficultyLevelSeeder::class);

        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin.math@gmail.com',
        ]);

        $user->assignRole('Super Admin');
    }
}
