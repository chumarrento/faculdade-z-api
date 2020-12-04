<?php

namespace Tests\Unit;

use App\Exports\SchoolRecordReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolRecordReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanGeneratePdfFile()
    {
        $student = $this->createStudentSchoolRecordMock();

        $schoolRecord = $student->getSchoolRecord();

        (new SchoolRecordReport())->handle($student, $schoolRecord);
        $file = "/school-records/Historico_$student->registration.pdf";
        $this->assertFileExists(storage_path() . $file);
    }
}
