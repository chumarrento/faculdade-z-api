<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolRecordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function studentCanLoadYourSchoolRecords()
    {
        $student = $this->createStudentSchoolRecordMock();

        $this->actingAs($student);

        $response = $this->get('/api/students/me/school-records');

        $response->assertStatus(200);
        $disciplines = $student->disciplines;

        $expected = $disciplines->map(function ($discipline) {
            return [
                'discipline_name' => $discipline->name,
                'discipline_teacher' => $discipline->teacher->name,
                'status' => $discipline->pivot->status,
                'final_grade' => $discipline->pivot->final_grade
            ];
        });

        $response->assertJson($expected->toArray());
    }
}
