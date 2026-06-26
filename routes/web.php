<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Mahasiswa\KrsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            
            Route::get('/jadwal', [AdminController::class, 'indexJadwal'])->name('jadwal.index');            
            Route::post('/jadwal/store', [AdminController::class, 'storeJadwal'])->name('jadwal.store');
            
            //tempat CRUD admin lainnya (Dosen,Mahasiswa, Matakuliah) tulis disini
        });

    // KELOMPOK ROUTE KHUSUS MAHASISWA (Spatie Middleware + Prefix + Named Routes)
    Route::middleware(['role:mahasiswa'])
        ->prefix('mahasiswa')
        ->name('mahasiswa.')
        ->group(function () {
            
            Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');            
            Route::post('/krs/simpan', [KrsController::class, 'store'])->name('krs.simpan');
        });
});

require __DIR__.'/auth.php';
