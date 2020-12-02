<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function studentCanLoadYourCurrentSemesterInfo()
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
                'status' => $discipline->pivot->status,
                'final_grade' => $discipline->pivot->final_grade
            ];
        });

        $response->assertJson($expected->toArray());
    }
}
