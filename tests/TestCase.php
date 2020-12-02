<?php

namespace Tests;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\Student;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    public function createStudentDisciplinesMock(): Student
    {
        $course = Course::factory()
            ->hasAttached(Discipline::factory()
                ->hasSchedules(1)
                ->hasTeacher(1)
                ->count(2),
                ['semester' => 1]
            )
            ->create();
        $disciplines = $course->disciplines;

        $student = Student::factory()->create(['course_id' => $course->id, 'current_semester' => 1]);
        $disciplines->each(function ($discipline) use ($student) {
            $finalGrade = rand(0, 10);
            $student->disciplines()->attach($discipline, [
                'status' => $finalGrade > 7 ? 'Aprovado' : 'Reprovado',
                'final_grade' => $finalGrade
            ]);
        });

        return $student;
    }
}
