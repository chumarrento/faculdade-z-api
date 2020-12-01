<?php

namespace Tests\Unit;

use App\Models\Difficulty;
use App\Models\Discipline;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
