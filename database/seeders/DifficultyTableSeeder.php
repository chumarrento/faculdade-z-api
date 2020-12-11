<?php

namespace Database\Seeders;

use App\Models\Difficulty;
use Illuminate\Database\Seeder;

class DifficultyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $difficulties = collect([
            [
                'name' => 'Fácil'
            ],
            [
                'name' => 'Médio'
            ],
            [
                'name' => 'Difícil'
            ]
        ]);

        Difficulty::truncate();

        $difficulties->each(function($difficulty) {
            Difficulty::create($difficulty);
        });
    }
}
