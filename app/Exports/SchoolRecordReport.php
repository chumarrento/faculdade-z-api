<?php


namespace App\Exports;


use App\Models\Student;
use PDF;
use Illuminate\Support\Collection;

class SchoolRecordReport
{
    public function handle(Student $student, Collection $schoolRecords)
    {
        $pdf = PDF::loadView('pdf.school-record', ['student' => $student, 'schoolRecords' => $schoolRecords]);
        $fileName = "school-records/Historico_$student->registration.pdf";
        $pdf->save(storage_path() . "/$fileName");
    }
}
