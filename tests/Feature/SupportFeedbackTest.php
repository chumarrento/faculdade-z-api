<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportFeedbackTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function studentCanAddAFeedback()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $attributes = Support::factory()->raw();
        $response = $this->json('POST', '/api/feedback', [
            'message' => $attributes['message']
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseHas('supports', [
            'message' => $attributes['message'],
            'student_id' => $student->id
        ]);
    }

    /** @test */
    public function feedbackRequiresAMessage()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $this->json('POST', '/api/feedback', [
            'message' => ''
        ])->assertJsonValidationErrors('message');
    }

    /** @test */
    public function feedbackRequiresAStringMessage()
    {
        $student = Student::factory()->create();
        $this->actingAs($student);

        $this->json('POST', '/api/feedback', [
            'message' => 1234
        ])->assertJsonValidationErrors('message');
    }
}
