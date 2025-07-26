<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\WelcomeController;

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/sendPasswordResetLink', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('send-password-reset-link');
Route::get('/passwordReset/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password-reset');
Route::post('/passwordReset/{token}', [ResetPasswordController::class, 'updatePassword'])->name('password-reset-post');
Route::get('/createNewPassword', [AuthController::class, 'createPassword'])->name('create-new-password');
Route::get('acceptInvitation/{id}/{email}', [InvitationController::class, 'accept'])->name('accept-invitation')->middleware('signed');
Route::get('/test', [DashboardController::class, 'test'])->name('test');

Route::middleware('jwt.web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('tasks', TaskController::class);
    Route::resource('projects',     ProjectController::class);
    Route::resource('invitation', InvitationController::class);
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
});