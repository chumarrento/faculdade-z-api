<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Difficulty;
use App\Models\Discipline;
use App\Models\Schedule;
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

    /** @test */
    public function itHasSchedules()
    {
        $discipline = Discipline::factory()->create();

        $this->assertInstanceOf(Collection::class, $discipline->schedules);
    }

    /** @test */
    public function itCanAddASchedule()
    {
        $discipline = Discipline::factory()->create();

        $scheduleAttributes = Schedule::factory()->raw(['discipline_id' => $discipline->id]);

        $discipline->addSchedule($scheduleAttributes);

        $this->assertDatabaseHas('schedules', [
            'weekday' => $scheduleAttributes['weekday'],
            'start_time' => $scheduleAttributes['start_time'],
            'end_time' => $scheduleAttributes['end_time'],
            'discipline_id' => $discipline->id
        ]);
    }
}
