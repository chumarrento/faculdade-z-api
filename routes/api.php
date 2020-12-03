<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Students\MeController;
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
        Route::get('me/current-semester-info', [MeController::class, 'getCurrentSemesterInfo']);
        Route::get('me/school-records', [MeController::class, 'getSchoolRecords']);
        Route::put('/me', [MeController::class, 'update']);
    });
});
