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
        $student = $this->createStudentDisciplinesMock();
        $disciplines = $student->disciplines;

        $this->actingAs($student);

        $response = $this->get('api/students/me/current-semester-info');

        $expected = $disciplines->map(function ($discipline) {
            return [
                'discipline_name' => $discipline->name,
                'discipline_difficulty' => $discipline->difficulty->name,
                'discipline_teacher' => $discipline->teacher->name,
                'discipline_schedule' => [
                    'weekday' => $discipline->schedule->weekday,
                    'start_time' => $discipline->schedule->start_time,
                    'end_time' => $discipline->schedule->end_time,
                ],
                'status' => $discipline->status,
                'final_grade' => $discipline->final_grade
            ];
        });

        $response->assertJson($expected->toArray());
    }
}
