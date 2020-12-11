<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');

        $this->call(CourseTableSeeder::class);
        $this->call(TeachersTableSeeder::class);
        $this->call(DifficultyTableSeeder::class);
        $this->call(DisciplinesTableSeeder::class);
        $this->call(CourseDisciplinesTableSeeder::class);
        $this->call(SchedulesTableSeeder::class);
        $this->call(StudentTableSeeder::class);
        $this->call(StudentDisciplinesTableSeeder::class);

        DB::statement('SET foreign_key_checks=1');
    }
}
