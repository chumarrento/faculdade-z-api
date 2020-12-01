<?php

namespace Tests\Unit;

use App\Models\Discipline;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itBelongsToADiscipline()
    {
        $schedule = Schedule::factory()->create();

        $this->assertInstanceOf(Discipline::class, $schedule->discipline);
    }
}
