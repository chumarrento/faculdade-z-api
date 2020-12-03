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
}
