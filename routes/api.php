<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AbsentController;
use App\Http\Controllers\API\LeaveController;
use App\Http\Controllers\API\PasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('user/photo', [UserController::class, 'updatePhoto']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('employee', [UserController::class, 'addEmployee']);
    Route::post('password/reset', [PasswordController::class, 'reset']);
    Route::post('absent', [AbsentController::class, 'absent']);
    Route::get('absent/history', [AbsentController::class, 'history']);
    Route::post('absent/spot', [AbsentController::class, 'absentSpot']);
    Route::get('absent/spot', [AbsentController::class, 'getAbsentSpot']);
    Route::post('leave', [LeaveController::class, 'leave']);
    Route::get('leave/history', [LeaveController::class, 'history']);
    Route::get('leave/types', [LeaveController::class, 'leaveType']);
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('password/forgot', [PasswordController::class, 'sendResetLinkEmail']);
