<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    /** @test */
    public function aStudentCanLogin()
    {
        $student = Student::factory()->create();

        $response = $this->post('api/login', [
            'cpf' => $student->cpf,
            'password' => 'password'
        ]);

        $response->assertJson([
            'user' => [
                'registration' => $student->registration,
                'name' => $student->name,
                'email' => $student->email,
                'cpf' => $student->cpf,
                'course' => [
                    'id' => $student->course_id,
                    'name' => $student->course->name
                ]
            ]
        ]);

        $response->assertStatus(200);
    }
}
