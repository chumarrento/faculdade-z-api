<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Difficulty;
use App\Models\Discipline;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class DisciplineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itHasATeacher()
    {
        $discipline = Discipline::factory()->create();

        $this->assertInstanceOf(Teacher::class, $discipline->teacher);
    }

    /** @test */
    public function itHasADifficulty()
    {
        $discipline = Discipline::factory()->create();

        $this->assertInstanceOf(Difficulty::class, $discipline->difficulty);
    }

    /** @test */
    public function itHasCourses()
    {
        $discipline = Discipline::factory()
            ->hasAttached(
                Course::factory()->count(1),
                ['semester' => 1]
            )
            ->create();

        $this->assertInstanceOf(Collection::class, $discipline->courses);
    }

    /** @test */
    public function itHasStudents()
    {
        $discipline = Discipline::factory()
            ->has(
                Student::factory()->count(1),
            )
            ->create();

        $this->assertInstanceOf(Collection::class, $discipline->students);
    }
}
