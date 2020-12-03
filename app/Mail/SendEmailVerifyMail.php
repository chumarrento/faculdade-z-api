<?php

namespace App\Mail;

use App\Models\Student;
use App\Models\StudentToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailVerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var StudentToken
     */
    private StudentToken $studentToken;
    /**
     * @var Student
     */
    private Student $student;

    /**
     * Create a new message instance.
     *
     * @param StudentToken $studentToken
     * @param Student $student
     */
    public function __construct(StudentToken $studentToken, Student $student)
    {
        $this->$studentToken = $studentToken;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email-verify')
                ->with([
                    'studentToken' => $this->studentToken,
                    'student' => $this->student
                ]);
    }
}
