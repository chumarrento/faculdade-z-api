<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
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
        $student = $this->createStudentDisciplinesMock();
        $disciplines = $student->disciplines;

        $currentSemesterInfo = $student->getCurrentSemesterInfo();

        $expected = $disciplines->map(function ($discipline) {
            return [
                'discipline_name' => $discipline->name,
                'discipline_difficulty' => $discipline->difficulty->name,
                'discipline_teacher' => $discipline->teacher->name,
                'discipline_schedule' => [
                    'weekday' => $discipline->schedule->weekday,
                    'start_time' => $discipline->schedule->start_time,
                    'end_time' => $discipline->schedule->end_time,
                ],
                'status' => $discipline->pivot->status,
                'final_grade' => $discipline->pivot->final_grade
            ];
        });

        $this->assertEquals($expected, $currentSemesterInfo);
    }

    /** @test */
    public function itCanLoadSpecificStudentDisciplineInfoWithCorrectValues()
    {
        $student = $this->createStudentDisciplinesMock();
        $studentDisciplines = $student->disciplines;

        $studentDisciplines->each(function ($discipline) use ($student) {
            $studentDisciplineInfo = $student->getStudentDisciplineInfo($discipline->id);
            $this->assertEquals($discipline, $studentDisciplineInfo);
        });
    }

    /** @test */
    public function itCanLoadSchoolRecords()
    {
        $student = $this->createStudentSchoolRecordMock();

        $schoolRecords = $student->getSchoolRecord();
        $disciplines = $student->disciplines;
        $expected = $disciplines->map(function ($discipline) {
            return [
                'discipline_name' => $discipline->name,
                'discipline_teacher' => $discipline->teacher->name,
                'status' => $discipline->pivot->status,
                'final_grade' => $discipline->pivot->final_grade
            ];
        });

        $this->assertEquals($expected, $schoolRecords);
    }

    /** @test */
    public function itHasAEncryptedPassword()
    {
        $user = Student::factory()->create(['password' => 'valid_password']);

        $this->assertTrue(Hash::check('valid_password', $user->password));
    }

    /** @test */
    public function itHasTokens()
    {
        $student = Student::factory()->create();

        $this->assertInstanceOf(Collection::class, $student->studentTokens);
    }

    /** @test */
    public function itCanCreateToken()
    {
        $student = Student::factory()->create();

        $student->createStudentToken();

        $this->assertDatabaseCount('student_tokens', 1);
    }
}
