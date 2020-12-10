<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSchoolRecordsReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Student
     */
    private Student $student;
    private string $file;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Student $student, string $file)
    {
        $this->student = $student;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email-school-records')
            ->with(['student' => $this->student])
            ->attach($this->file);
    }
}
