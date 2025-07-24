<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HasilProduksiController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PemupukanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('auth.login');
})->middleware(['auth', 'verified'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/', [UserController::class, 'beranda'])->name('beranda');
    Route::get('/beranda', [UserController::class, 'beranda'])->name('beranda');
    Route::post('/produksi', [UserController::class, 'storeProduksi'])->name('produksi.store');
    Route::get('/activities', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('/api/activities', [ActivityController::class, 'getActivities'])->name('activity.get');
    Route::post('/hasil-produksi', [HasilProduksiController::class, 'store'])->name('hasil-produksi.store');
    Route::post('/pemupukan', [PemupukanController::class, 'store'])->name('pemupukan.store');
});

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('manager/beranda', [ManagerController::class, 'beranda'])->name('manager.beranda');
    Route::get('manager/laporan', [ManagerController::class, 'laporan'])->name('manager.laporan');
    Route::get('manager/statistik', [ManagerController::class, 'statistik'])->name('manager.statistik');
});

require __DIR__ . '/auth.php';
