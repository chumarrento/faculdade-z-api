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
        $course = Course::factory()->create();
        $currentStudentSemester = rand(1, 8);

        $student = Student::factory()->create([
            'current_semester' => $currentStudentSemester,
            'course_id' => $course->id
        ]);

        for ($i = 0; $i < $currentStudentSemester; $i++) {
            $discipline = Discipline::factory()->create();
            $course->disciplines()->attach($discipline, ['semester' => $i]);

            $finalGrade = rand(0, 10);
            $student->disciplines()->attach($discipline, [
                'status' => $finalGrade > 7 ? 'Aprovado' : 'Reprovado',
                'final_grade' => $finalGrade
            ]);
        }

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
