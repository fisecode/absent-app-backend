<?php

use App\Models\Leave;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AbsentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\AbsentSpotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('/forgot-password', function () {
    return view('adminlte::auth.passwords.reset');
})->name('password.request');

Route::prefix('dashboard')
    ->middleware(['auth:sanctum', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('user', UserController::class);
        Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::get('user/{id}/password', [UserController::class, 'showPassword'])->name('show.password');
        Route::put('user/{id}/password/update', [UserController::class, 'updatePassword'])->name('update.password');
        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::get('profile/update/{id}', [UserController::class, 'updateProfile'])->name('updateProfile');
        Route::get('change-password', [UserController::class, 'updatePasswordProfile'])->name('updatePasswordProfile');
        Route::resource('employee', EmployeeController::class);
        Route::get('employee/delete/{id}', [EmployeeController::class, 'delete'])->name('deleteEmployee');
        Route::resource('absentspot', AbsentSpotController::class);
        Route::get('absentspot/delete/{absentspot}', [AbsentSpotController::class, 'delete'])->name('absentspot.delete');
        Route::get('absentspot/{absentspot}/action', [AbsentSpotController::class, 'action'])->name('absentspot.action');
        Route::post('absentspot/{absentspot}/approval', [AbsentSpotController::class, 'approval'])->name('absentspot.approval');
        Route::resource('leavetype', LeaveTypeController::class);
        Route::get('leavetype/delete/{id}', [LeaveTypeController::class, 'delete'])->name('leavetype.delete');
        Route::resource('leave', LeaveController::class);
        Route::get('leave/delete/{id}', [LeaveController::class, 'delete'])->name('leave.delete');
        Route::get('leave/{id}/action', [LeaveController::class, 'action'])->name('leave.action');
        Route::post('leave/{id}/approval', [LeaveController::class, 'approval'])->name('leave.approval');
        Route::resource('absent', AbsentController::class);
    });
