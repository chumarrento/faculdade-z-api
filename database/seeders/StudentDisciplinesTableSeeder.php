<?php

namespace Database\Seeders;

use App\Models\Discipline;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentDisciplinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();
        DB::table('disciplines_students')->truncate();

        $students->each(function ($stundent) {
            $this->addStudentDisciplineData($stundent);
        });
    }

    private function addStudentDisciplineData(Student $student)
    {
        $disciplines = Discipline::all();

        $disciplines->each(function ($discipline) use ($student) {
            $disciplineSemester = $discipline->courses()->first()->pivot->semester;

            if ($disciplineSemester <= $student->current_semester) {
                if ($disciplineSemester < $student->current_semester) {
                    $final_grade = rand(0, 10);
                    $status = $final_grade > 7 ? 'Aprovado' : 'Reprovado';
                } else {
                    $final_grade = null;
                    $status = 'Em Andamento';
                }
                $student->disciplines()->attach($discipline, [
                    'final_grade' => $final_grade,
                    'status' => $status
                ]);
            }
        });
    }
}
