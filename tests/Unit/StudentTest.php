<?php

namespace Tests\Unit;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canCreateAUser()
    {
        $attributes = Student::factory()->raw();
        Student::create($attributes);

        $this->assertDatabaseHas('students', [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'registration' => $attributes['registration'],
            'cpf' => $attributes['cpf'],
            'course_id' => $attributes['course_id']
        ]);
    }
}
