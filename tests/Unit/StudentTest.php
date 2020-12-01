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
    public function canCreateAStudent()
    {
        $attributes = Student::factory()->raw();
        Student::create($attributes);

        $this->assertDatabaseHas('students', [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'registration' => $attributes['registration'],
            'cpf' => $attributes['cpf'],
            'current_semester' => $attributes['current_semester'],
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

    /** @test */
    public function itHasSupports()
    {
        $student = Student::factory()->create();

        $this->assertInstanceOf(Collection::class, $student->supportContacts);
    }

    /** @test */
    public function itCanAddAFeedbackOnSupport()
    {
        $student = Student::factory()->create();

        $message = 'any_message';
        $student->addFeedback($message);

        $this->assertDatabaseHas('supports', [
            'message' => $message,
            'student_id' => $student->id
        ]);
    }

    /** @test */
    public function itCanLoadCurrentSemesterInfo()
    {
        $course = Course::factory()
            ->hasAttached(Discipline::factory()
                ->hasSchedules(1)
                ->hasTeacher(1)
                ->count(2),
                ['semester' => 1]
            )
            ->create();
        $disciplines = $course->disciplines;

        $student = Student::factory()->create(['course_id' => $course->id, 'current_semester' => 1]);
        $student->disciplines()->sync($disciplines);

        $currentSemesterInfo = $student->getCurrentSemesterInfo();

        $expected = $disciplines->map(function ($discipline) {
            $studentDisciplineInfo = $discipline->students->first();
            return [
                'discipline_name' => $discipline->name,
                'discipline_difficulty' => $discipline->difficulty->name,
                'discipline_teacher' => $discipline->teacher->name,
                'discipline_schedule' => [
                    'weekday' => $discipline->schedule->weekday,
                    'start_time' => $discipline->schedule->start_time,
                    'end_time' => $discipline->schedule->end_time,
                ],
                'status' => $studentDisciplineInfo->status,
                'final_grade' => $studentDisciplineInfo->final_grade
            ];
        });

        $this->assertEquals($expected, $currentSemesterInfo);
    }
}
