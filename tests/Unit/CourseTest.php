<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Discipline;
use Database\Seeders\CourseTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canCreateACourse()
    {
        $attributes = Course::factory()->raw();
        $course = Course::create($attributes);

        $this->assertDatabaseHas('courses', [
            'name' => $course->name,
            'semesters' => $course->semesters
        ]);
    }

    /** @test */
    public function itHasStudents()
    {
        $course = Course::factory()->create();

        $this->assertInstanceOf(Collection::class, $course->students);
    }

    /** @test */
    public function itHasDisciplines()
    {
        $course = Course::factory()
            ->hasAttached(
                Discipline::factory()->count(1),
                ['semester' => 1]
            )
            ->create();

        $this->assertInstanceOf(Collection::class, $course->disciplines);
    }

    /** @test */
    public function itCanLoadDisciplinesBySemester()
    {
        $count = 2;
        $semester = 1;
        $course = Course::factory()
            ->hasAttached(
                Discipline::factory()->count($count),
                ['semester' => $semester]
            )
            ->create();

        $disciplines = $course->getDisciplinesBySemester($semester);
        $this->assertEquals($count, $disciplines->count());
        $this->assertInstanceOf(Collection::class, $disciplines);
    }

    /** @test */
    public function itCanLoadAllPreviousSemesterDisciplines()
    {
        $count = 8;
        $course = Course::factory()->create(['semesters' => $count]);
        for ($i = 0; $i < $count; $i++) {
            $discipline = Discipline::factory()->create();
            $course->disciplines()->attach($discipline, ['semester' => $i]);
        }

        $disciplines = $course->getPreviousDisciplinesBySemester($count);
        $this->assertEquals($count, $disciplines->count());
        $this->assertInstanceOf(Collection::class, $disciplines);
    }
}
