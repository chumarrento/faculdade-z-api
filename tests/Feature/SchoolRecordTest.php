<?php

namespace Tests\Feature;

use App\Exports\SchoolRecordReport;
use App\Mail\SendSchoolRecordsReportMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SchoolRecordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function studentCanLoadYourSchoolRecords()
    {
        $student = $this->createStudentSchoolRecordMock();

        $this->actingAs($student);

        $response = $this->get('/api/students/me/school-records');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'semester',
                'disciplines' => [
                    '*' => [
                        'discipline_name',
                        'discipline_teacher',
                        'semester',
                        'status',
                        'final_grade'
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function studentDownloadYourSchoolRecords()
    {
        $student = $this->createStudentSchoolRecordMock();

        $this->actingAs($student);

        $response = $this->get('/api/students/me/school-records/report');
        $expectedFileName = "Historico_$student->registration.pdf";

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertHeader('Content-Disposition', "attachment; filename=$expectedFileName");
    }

    /** @test */
    public function studentCanReceiveYourSchoolRecordsOnEmail()
    {
        Mail::fake();

        $student = $this->createStudentSchoolRecordMock();

        $this->actingAs($student);

        $this->get('/api/students/me/school-records/report?email=true')->assertStatus(204);


        Mail::assertSent(SendSchoolRecordsReportMail::class);
    }

    /** @test */
    public function studentCannotReceiveYourSchoolRecordsOnEmailIfThereAreNotVerified()
    {
        Mail::fake();

        $student = $this->createStudentSchoolRecordMock(false);

        $this->actingAs($student);

        $this->get('/api/students/me/school-records/report?email=true')->assertStatus(400);

        Mail::assertNotSent(SendSchoolRecordsReportMail::class);
    }
}
