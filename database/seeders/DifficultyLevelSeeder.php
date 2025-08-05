<?php

namespace Database\Seeders;

use App\Models\DifficultyLevel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DifficultyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DifficultyLevel::firstOrCreate([
            'name' => 'Easy',
            'time_limit' => '00:30',
        ]);
        DifficultyLevel::firstOrCreate([
            'name' => 'Average',
            'time_limit' => '00:20',
        ]);
        DifficultyLevel::firstOrCreate([
            'name' => 'Difficult',
            'time_limit' => '00:10',
        ]);
    }
}
