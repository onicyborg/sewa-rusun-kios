<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route lainnya untuk admin atau user
    Route::group(['middleware' => 'role:admin'], function () {
        // Route khusus admin
    });

    Route::group(['middleware' => 'role:user'], function () {
        // Route khusus user
    });
});

Route::get('/login', function(){
    return view('login');
})->name('login');
Route::get('/register', function(){
    return view('register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
