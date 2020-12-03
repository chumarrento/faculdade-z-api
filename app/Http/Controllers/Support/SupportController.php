<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSupportFeedbackRequest;
use App\Utils\ApiResponse;;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    use ApiResponse;

    public function create(CreateSupportFeedbackRequest $request)
    {
        $message = $request->post('message');
        Auth::user()->addFeedback($message);

        return $this->noContent();
    }
}
