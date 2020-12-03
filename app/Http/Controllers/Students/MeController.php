<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentUpdateRequest;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\Auth;

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
        $schoolRecords = Auth::user()->getSchoolRecord();
        return $this->success($schoolRecords);
    }

    public function update(StudentUpdateRequest $request)
    {
        $attributes = $request->only(['name','email', 'cpf']);

        $user = Auth::user();
        if (array_key_exists('email', $attributes) && $user->email !== $attributes['email']) {
            $attributes['email_verified_at'] = null;
        }

        Auth::user()->update($attributes);

        return $this->noContent();
    }
}
