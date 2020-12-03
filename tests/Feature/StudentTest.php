<?php

namespace Tests\Feature;

use App\Models\Student;
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

    /** @test */
    public function studentCanUpdateYourData()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $attributes = Student::factory()->raw();

        $response = $this->json('PUT', 'api/students/me', [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'cpf' => $attributes['cpf']
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'email_verified_at' => null,
            'cpf' => $attributes['cpf'],
            'registration' => $student->registration,
            'current_semester' => $student->current_semester,
            'course_id' => $student->course_id
        ]);
    }

    /** @test */
    public function studentCanUpdateYourDataWithoutEmail()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $attributes = Student::factory()->raw();

        $response = $this->json('PUT', 'api/students/me', [
            'name' => $attributes['name'],
            'cpf' => $attributes['cpf']
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => $attributes['name'],
            'email' => $student->email,
            'email_verified_at' => $student->email_verified_at,
            'cpf' => $attributes['cpf'],
            'registration' => $student->registration,
            'current_semester' => $student->current_semester,
            'course_id' => $student->course_id
        ]);
    }
}
