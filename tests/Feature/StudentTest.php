<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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

    /** @test */
    public function aStudentUpdateRequiresAStringCpf()
    {
        $this->actingAs(Student::factory()->create());
        $response = $this->json('PUT', 'api/students/me', [
            'cpf' => 1234,
            'email' => 'any_email@email.com',
            'name' => 'any_name'
        ])->assertJsonValidationErrors('cpf');
    }

    /** @test */
    public function aStudentUpdateRequiresAValidCpfSize()
    {
        $this->actingAs(Student::factory()->create());
        $this->json('PUT', 'api/students/me', [
            'cpf' => 'invalid_cpf_size',
            'email' => 'any_email@email.com',
            'name' => 'any_name'
        ])->assertJsonValidationErrors('cpf');
    }

    /** @test */
    public function aStudentUpdateRequiresAUniqueCpf()
    {
        $otherStudent = Student::factory()->create();
        $this->actingAs(Student::factory()->create());

        $this->json('PUT', 'api/students/me', [
            'cpf' => $otherStudent->cpf,
            'email' => 'any_email@email.com',
            'name' => 'any_name'
        ])->assertJsonValidationErrors('cpf');
    }

    /** @test */
    public function aStudentUpdateRequiresAValidEmail()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);
        $this->json('PUT', 'api/students/me', [
            'cpf' => $student->cpf,
            'email' => 'invalid_email',
            'name' => 'any_name'
        ])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function aStudentUpdateRequiresAUniqueEmail()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $otherStudent = Student::factory()->create();

        $this->json('PUT', 'api/students/me', [
            'cpf' => $student->cpf,
            'email' => $otherStudent->email,
            'name' => 'any_name'
        ])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function aStudentUpdateRequiresAStringName()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);
        $this->json('PUT', 'api/students/me', [
            'cpf' => $student->cpf,
            'email' => 'any_email@email.com',
            'name' => 123
        ])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function studentCanChangeYourPassword()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $attributes = Student::factory()->raw(['password' => 'new_password']);

        $response = $this->json('PUT', 'api/students/me/change-password', [
            'old_password' => 'password',
            'new_password' => $attributes['password'],
            'new_password_confirmation' => $attributes['password']
        ]);

        $response->assertStatus(204);
        $this->assertTrue(Hash::check('new_password', $student->password));
    }

    /** @test */
    public function aStudentChangeRequiresAOldPassword()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $this->json('PUT', 'api/students/me/change-password', [
            'old_password' => '',
            'new_password' => 'new_valid_password',
            'new_password_confirmation' => 'new_valid_password'
        ])->assertJsonValidationErrors('old_password');
    }

    /** @test */
    public function aStudentChangeRequiresAStringOldPassword()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $this->json('PUT', 'api/students/me/change-password', [
            'old_password' => 1234,
            'new_password' => 'new_valid_password',
            'new_password_confirmation' => 'new_valid_password'
        ])->assertJsonValidationErrors('old_password');
    }

    /** @test */
    public function aStudentChangeRequiresANewPassword()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $this->json('PUT', 'api/students/me/change-password', [
            'old_password' => 'password',
            'new_password' => '',
            'new_password_confirmation' => ''
        ])->assertJsonValidationErrors('new_password');
    }

    /** @test */
    public function aStudentChangeRequiresAStringNewPassword()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $this->json('PUT', 'api/students/me/change-password', [
            'old_password' => 'password',
            'new_password' => 1234,
            'new_password_confirmation' => 1234
        ])->assertJsonValidationErrors('new_password');
    }

    /** @test */
    public function aStudentChangeRequiresAConfirmedNewPassword()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $this->json('PUT', 'api/students/me/change-password', [
            'old_password' => 'password',
            'new_password' => 'new_valid_password',
            'new_password_confirmation' => 'incorrect_new_password'
        ])->assertJsonValidationErrors('new_password');
    }
}
