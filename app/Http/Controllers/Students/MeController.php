<?php

namespace App\Http\Controllers\Students;

use App\Exports\SchoolRecordReport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentChangePasswordRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Mail\SendSchoolRecordsReportMail;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MeController extends Controller
{
    use ApiResponse;

    public function getCurrentSemesterInfo()
    {
        $currentSemesterInfo = Auth::user()->getCurrentSemesterInfo();
        return $this->success($currentSemesterInfo);
    }

    public function getSchoolRecords()
    {
        $schoolRecords = Auth::user()->getSchoolRecordGroupedBySemester();
        return $this->success($schoolRecords);
    }

    public function getSchoolRecordsReport()
    {
        try {
            $student = Auth::user();
            $schoolRecords = $student->getSchoolRecord();
            (new SchoolRecordReport())->handle($student, $schoolRecords);
            $pdf = storage_path() . "/school-records/Historico_$student->registration.pdf";

            if (request()->query('email')) {
                if (!$student->hasVerifiedEmail()) {
                    Storage::delete($pdf);
                    return $this->bad();
                }
                Mail::to($student)->send((new SendSchoolRecordsReportMail($student, $pdf)));

                Storage::delete($pdf);
                return $this->noContent();
            }

            return response()->download($pdf)->deleteFileAfterSend(true);
        } catch (\Exception $exception) {
            Storage::delete($pdf);
            return $this->internalError(['message' => 'Ocorreu um erro ao enviar o email ou criar o arquivo.']);
        }
    }

    public function update(StudentUpdateRequest $request)
    {
        $attributes = $request->only(['name', 'email', 'cpf']);

        $user = Auth::user();
        if (array_key_exists('email', $attributes) && $user->email !== $attributes['email']) {
            $attributes['email_verified_at'] = null;
        }

        Auth::user()->update($attributes);

        return $this->noContent();
    }

    public function changePassword(StudentChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->post('old_password'), $user->password)) {
            return $this->bad(['message' => 'Senha atual inválida']);
        }

        $attributes['password'] = $request->post('new_password');
        Auth::user()->update($attributes);

        return $this->noContent();
    }

    public function sendEmailVerification()
    {
        $user = Auth::user();

        if (!is_null($user->email_verified_at)) {
            return $this->bad();
        }

        $user->createStudentToken();

        return $this->noContent();
    }

    public function verifyEmailWithToken($token)
    {
        $user = Auth::user();
        if (is_null($user->email_verified_at)) {
            $verify = $user->verifyEmail($token);

            if ($verify) {
                return $this->noContent();
            }
        }
        return $this->bad();
    }
}
