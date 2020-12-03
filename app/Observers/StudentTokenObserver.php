<?php

namespace App\Observers;

use App\Mail\SendEmailVerifyMail;
use App\Models\StudentToken;
use Illuminate\Support\Facades\Mail;

class StudentTokenObserver
{
    public function created(StudentToken $studentToken)
    {
        $student = $studentToken->student;

        Mail::to($student)->send(new SendEmailVerifyMail($studentToken, $student));
    }
}
