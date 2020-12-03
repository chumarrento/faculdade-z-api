<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
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
}
