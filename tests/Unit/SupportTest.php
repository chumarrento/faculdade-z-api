<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Models\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itBelongsToAStudent()
    {
        $support = Support::factory()->create();

        $this->assertInstanceOf(Student::class, $support->student);
    }
}
