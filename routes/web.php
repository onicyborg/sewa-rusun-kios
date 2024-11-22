<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RusunController;
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
        Route::get('/manage-rusun', [RusunController::class, 'index']);
        Route::post('/manage-rusun/store', [RusunController::class, 'store'])->name('rusun.store');
        Route::put('/manage-rusun/update', [RusunController::class, 'update'])->name('rusun.update');
        Route::delete('/manage-rusun/delete', [RusunController::class, 'destroy'])->name('rusun.delete');

        //datatables
        Route::get('/rusun-data', [RusunController::class, 'getData']);
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
