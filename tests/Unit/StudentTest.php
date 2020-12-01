<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
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

    /** @test */
    public function itBelongsToACourse()
    {
        $student = Student::factory()->create();

        $this->assertInstanceOf(Course::class, $student->course);
    }

    /** @test */
    public function itHasDisciplines()
    {
        $student = Student::factory()
            ->has(Discipline::factory()->count(2))
            ->create();

        $this->assertInstanceOf(Collection::class, $student->disciplines);
    }
}
