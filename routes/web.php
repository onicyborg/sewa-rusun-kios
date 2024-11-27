<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KiosController;
use App\Http\Controllers\MekanikalController;
use App\Http\Controllers\RusunController;
use App\Http\Controllers\SewaGedungController;
use App\Http\Controllers\SewaKiosController;
use App\Http\Controllers\SewaRusunController;
use App\Http\Controllers\TagihanKiosController;
use App\Http\Controllers\TagihanRusunController;
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

Route::middleware(['check.expired'])->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        // Route lainnya untuk admin atau user
        Route::group(['middleware' => 'role:admin'], function () {
            Route::get('/manage-rusun', [RusunController::class, 'index']);
            Route::post('/manage-rusun/store', [RusunController::class, 'store'])->name('rusun.store');
            Route::put('/manage-rusun/update', [RusunController::class, 'update'])->name('rusun.update');
            Route::delete('/manage-rusun/delete', [RusunController::class, 'destroy'])->name('rusun.delete');

            Route::get('/manage-kios', [KiosController::class, 'index']);
            Route::post('/manage-kios/store', [KiosController::class, 'store'])->name('kios.store');
            Route::put('/manage-kios/update', [KiosController::class, 'update'])->name('kios.update');
            Route::delete('/manage-kios/delete', [KiosController::class, 'destroy'])->name('kios.delete');

            Route::get('/manage-mekanikal', [MekanikalController::class, 'index']);
            Route::post('/manage-mekanikal/store', [MekanikalController::class, 'store'])->name('mekanikal.store');
            Route::put('/manage-mekanikal/update', [MekanikalController::class, 'update'])->name('mekanikal.update');
            Route::delete('/manage-mekanikal/delete', [MekanikalController::class, 'destroy'])->name('mekanikal.delete');

            Route::get('/sewa-rusun', [SewaRusunController::class, 'index'])->name('sewa-rusun.index');
            Route::post('/sewa-rusun/store', [SewaRusunController::class, 'store'])->name('sewa-rusun.store');
            Route::put('/sewa-rusun/update/{id}', [SewaRusunController::class, 'update'])->name('sewa-rusun.update');
            Route::post('/tagihan-rusun/add', [TagihanRusunController::class, 'tagihan_bulanan']);
            Route::get('/detail-tagihan-bulanan/{bulan}/{tahun}', [TagihanRusunController::class, 'detail_tagihan']);
            Route::put('/update-tagihan/{id}', [TagihanRusunController::class, 'update_tagihan'])->name('update.tagihan');
            Route::post('/release-tagihan/{bulan}/{tahun}', [TagihanRusunController::class, 'release_tagihan'])->name('release.tagihan');

            Route::get('/sewa-kios', [SewaKiosController::class, 'index'])->name('sewa-kios.index');
            Route::post('/sewa-kios/store', [SewaKiosController::class, 'store'])->name('sewa-kios.store');
            Route::put('/sewa-kios/update/{id}', [SewaKiosController::class, 'update'])->name('sewa-kios.update');
            Route::post('/tagihan-kios/add', [TagihanKiosController::class, 'tagihan_bulanan']);
            Route::get('/detail-tagihan-bulanan-kios/{bulan}/{tahun}', [TagihanKiosController::class, 'detail_tagihan']);
            Route::put('/update-tagihan-kios/{id}', [TagihanKiosController::class, 'update_tagihan'])->name('update.tagihan-kios');
            Route::post('/release-tagihan-kios/{bulan}/{tahun}', [TagihanKiosController::class, 'release_tagihan'])->name('release.tagihan-kios');

            Route::get('/sewa-gedung', [SewaGedungController::class, 'index']);
            Route::post('/sewa-gedung/store', [SewaGedungController::class, 'store'])->name('sewa-gedung.store');
            Route::put('/sewa-gedung/update', [SewaGedungController::class, 'update'])->name('sewa-gedung.update');
            Route::delete('/sewa-gedung/destroy', [SewaGedungController::class, 'destroy'])->name('sewa-gedung.destroy');

            //datatables
            Route::get('/rusun-data', [RusunController::class, 'getData']);
            Route::get('/kios-data', [KiosController::class, 'getData']);
            Route::get('/mekanikal-data', [MekanikalController::class, 'getData']);
            Route::get('/tagihan-rusun', [TagihanRusunController::class, 'index'])->name('tagihanRusun.index');
            Route::get('/tagihan-kios', [TagihanKiosController::class, 'index'])->name('tagihanKios.index');
        });

        Route::group(['middleware' => 'role:user'], function () {
            // Route khusus user
        });
    });

    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::get('/register', function () {
        return view('register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});
