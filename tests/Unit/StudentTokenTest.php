<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Models\StudentToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itBelongsToAStudent()
    {
        $studentToken = StudentToken::factory()->create();
        $this->assertInstanceOf(Student::class, $studentToken->student);
    }
}
