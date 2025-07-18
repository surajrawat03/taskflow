<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvitationController;

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
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);
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