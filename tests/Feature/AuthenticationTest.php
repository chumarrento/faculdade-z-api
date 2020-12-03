<?php

namespace Tests\Feature;

use App\Mail\SendEmailVerifyMail;
use App\Models\Student;
use App\Models\StudentToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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

        $response = $this->json('POST', 'api/login', [
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

    /** @test */
    public function aStudentCannotLoginWithInvalidCredentials()
    {
        $student = Student::factory()->create();

        $response = $this->json('POST', 'api/login', [
            'cpf' => $student->cpf,
            'password' => 'invalid_password'
        ]);

        $response->assertJson([
            'message' => 'Login/Senha inválido',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function aStudentRequiresACpf()
    {
        $this->json('POST', 'api/login', [
            'cpf' => '',
            'password' => 'valid_password'
        ])->assertJsonValidationErrors('cpf');
    }

    /** @test */
    public function aStudentRequiresAStringCpf()
    {
        $this->json('POST', 'api/login', [
            'cpf' => 1234,
            'password' => 'valid_password'
        ])->assertJsonValidationErrors('cpf');
    }

    /** @test */
    public function aStudentRequiresAValidCpfSize()
    {
        $this->json('POST', 'api/login', [
            'cpf' => 'invalid_cpf_size',
            'password' => 'valid_password'
        ])->assertJsonValidationErrors('cpf');
    }

    /** @test */
    public function aStudentRequiresAPassword()
    {
        $this->json('POST', 'api/login', [
            'cpf' => 'any_cpf',
            'password' => ''
        ])->assertJsonValidationErrors('password');
    }

    /** @test */
    public function aStudentRequiresAStringPassword()
    {
        $this->json('POST', 'api/login', [
            'cpf' => 'any_cpf',
            'password' => 1234
        ])->assertJsonValidationErrors('password');
    }

    /** @test */
    public function studentCanSendEmailVerification()
    {
        Mail::fake();

        $student = Student::factory()->create(['email_verified_at' => null]);
        $this->actingAs($student);

        $response = $this->getJson('/api/students/me/send-email-verification');

        $response->assertStatus(204);

        $this->assertDatabaseCount('student_tokens', 1);

        Mail::assertSent(SendEmailVerifyMail::class);
    }

    /** @test */
    public function studentCannotSendEmailVerificationIfEmailIsVerified()
    {
        Mail::fake();

        $student = Student::factory()->create();
        $this->actingAs($student);

        $response = $this->getJson('/api/students/me/send-email-verification');

        $response->assertStatus(400);

        $this->assertDatabaseCount('student_tokens', 0);

        Mail::assertNothingSent();
    }

    /** @test */
    public function studentCanVerifyEmailWithToken()
    {
        $student = Student::factory()->create(['email_verified_at' => null]);
        $this->actingAs($student);

        $studentToken = StudentToken::factory()->create(['student_id' => $student->id]);

        $response = $this->getJson("/api/students/me/verify-email/$studentToken->token");

        $response->assertStatus(204);

        $this->assertDatabaseHas('student_tokens', [
            'token' => $studentToken->token,
            'used' => true,
            'student_id' => $student->id
        ]);

        $this->assertNotTrue(is_null($student->email_verified_at));
    }

    /** @test */
    public function studentCannotVerifyEmailWithInvalidToken()
    {
        $student = Student::factory()->create(['email_verified_at' => null]);
        $this->actingAs($student);

        $response = $this->getJson("/api/students/me/verify-email/invalid_token");

        $response->assertStatus(400);

        $this->assertTrue(is_null($student->email_verified_at));
    }
}
