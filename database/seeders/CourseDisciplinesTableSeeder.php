<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Discipline;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseDisciplinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disciplines = Discipline::all();
        $course = Course::first();
        DB::table('courses_disciplines')->truncate();

        $semester = 1;
        foreach ($disciplines as $key => $discipline) {
            if (($key + 1) % 5 == 0 && $semester < $course->semesters) {
                $semester++;
            }
            $discipline->courses()->attach($course, ['semester' => $semester]);
        }
    }
}
