<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;

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
        Route::get('/dashboard/user/delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::get('/dashboard/user/{id}/password', [UserController::class, 'showPassword'])->name('show.password');
        Route::put('/dashboard/user/{id}/password/update', [UserController::class, 'updatePassword'])->name('update.password');
        Route::resource('employee', EmployeeController::class);
        Route::get('/dashboard/employee/delete/{id}', [EmployeeController::class, 'delete'])->name('deleteEmployee');
    });
