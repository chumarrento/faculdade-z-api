<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Students\MeController;
use App\Http\Controllers\Support\SupportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'students'], function () {
        Route::get('/me/send-email-verification', [MeController::class, 'sendEmailVerification']);
        Route::get('me/verify-email/{token}', [MeController::class, 'verifyEmailWithToken']);
        Route::get('me/current-semester-info', [MeController::class, 'getCurrentSemesterInfo']);
        Route::get('me/school-records', [MeController::class, 'getSchoolRecords']);
        Route::get('me/school-records/report', [MeController::class, 'getSchoolRecordsReport']);
        Route::put('me', [MeController::class, 'update']);
        Route::put('me/change-password', [MeController::class, 'changePassword']);
    });

    Route::post('feedback', [SupportController::class, 'create']);
});
