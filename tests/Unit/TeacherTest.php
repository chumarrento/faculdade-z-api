<?php

namespace Tests\Unit;

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itHasDisciplines()
    {
        $teacher = Teacher::factory()->create();

        $this->assertInstanceOf(Collection::class, $teacher->disciplines);
    }
}
