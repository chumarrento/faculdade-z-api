<?php

namespace Tests\Unit;

use App\Models\Difficulty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class DifficultyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itHasDisciplines()
    {
        $difficulty = Difficulty::factory()->create();

        $this->assertInstanceOf(Collection::class, $difficulty->disciplines);
    }
}
