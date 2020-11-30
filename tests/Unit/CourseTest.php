<?php

namespace Tests\Unit;

use App\Models\Course;
use Database\Seeders\CourseTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function checkIfSeederRegisterCorrectValues()
    {
        $this->seed(CourseTableSeeder::class);

        $this->assertDatabaseHas('courses', [
            'id' => 1,
            'name' => 'Sistemas de Informação',
            'semesters' => 8
        ]);
    }
}
