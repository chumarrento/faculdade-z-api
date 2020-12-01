<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function loadCurrentSemesterInfoOfStudent()
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
        $student->disciplines()->sync($disciplines);

        $this->actingAs($student);

        $response = $this->get('api/students/me/current-semester-info');

        $expected = $disciplines->map(function ($discipline) {
            $studentDisciplineInfo = $discipline->students->first();
            return [
                'discipline_name' => $discipline->name,
                'discipline_difficulty' => $discipline->difficulty->name,
                'discipline_teacher' => $discipline->teacher->name,
                'discipline_schedule' => [
                    'weekday' => $discipline->schedule->weekday,
                    'start_time' => $discipline->schedule->start_time,
                    'end_time' => $discipline->schedule->end_time,
                ],
                'status' => $studentDisciplineInfo->status,
                'final_grade' => $studentDisciplineInfo->final_grade
            ];
        });

        $response->assertJson($expected->toArray());
    }
}
