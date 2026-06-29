<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Mahasiswa\KrsController;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Halaman Utama
Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

// 2. Route Dashboard Dinamis (Pengarah View berdasarkan Role)
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) return redirect()->route('login');

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('mahasiswa')) {
        $mhs = Mahasiswa::first();
        $npm = $mhs ? $mhs->npm : '2455201001';
        
        $krsDiambil = Krs::with(['matakuliah', 'matakuliah.jadwal.dosen'])->where('npm', $npm)->get();
        
        return view('mahasiswa.dashboard', compact('krsDiambil', 'npm'));
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Route Profile Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // KELOMPOK ROUTE KHUSUS ADMIN
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            // 1. CRUD DOSEN
            Route::get('/dosen', [AdminController::class, 'dosenIndex'])->name('dosen.index');
            Route::post('/dosen/store', [AdminController::class, 'dosenStore'])->name('dosen.store');
            Route::put('/dosen/update/{nidn}', [AdminController::class, 'dosenUpdate'])->name('dosen.update');
            Route::delete('/dosen/delete/{nidn}', [AdminController::class, 'dosenDelete'])->name('dosen.delete');

            // 2. CRUD MAHASISWA
            Route::get('/mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('mahasiswa.index');
            Route::post('/mahasiswa/store', [AdminController::class, 'mahasiswaStore'])->name('mahasiswa.store');
            Route::put('/mahasiswa/update/{npm}', [AdminController::class, 'mahasiswaUpdate'])->name('mahasiswa.update');
            Route::delete('/mahasiswa/delete/{npm}', [AdminController::class, 'mahasiswaDelete'])->name('mahasiswa.delete');

            // 3. CRUD MATA KULIAH
            Route::get('/matakuliah', [AdminController::class, 'matakuliahIndex'])->name('matakuliah.index');
            Route::post('/matakuliah/store', [AdminController::class, 'matakuliahStore'])->name('matakuliah.store');
            Route::put('/matakuliah/update/{kode}', [AdminController::class, 'matakuliahUpdate'])->name('matakuliah.update');
            Route::delete('/matakuliah/delete/{kode}', [AdminController::class, 'matakuliahDelete'])->name('matakuliah.delete');

            // 4. CRUD JADWAL PERKULIAHAN
            Route::get('/jadwal', [AdminController::class, 'jadwalIndex'])->name('jadwal.index');
            Route::post('/jadwal/store', [AdminController::class, 'jadwalStore'])->name('jadwal.store');
            Route::put('/jadwal/update/{id}', [AdminController::class, 'jadwalUpdate'])->name('jadwal.update');
            Route::delete('/jadwal/delete/{id}', [AdminController::class, 'jadwalDelete'])->name('jadwal.delete');
        });

    // KELOMPOK ROUTE KHUSUS MAHASISWA
    Route::middleware(['role:mahasiswa'])
        ->prefix('mahasiswa')
        ->name('mahasiswa.')
        ->group(function () {
            Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');            
            Route::post('/krs/simpan', [KrsController::class, 'store'])->name('krs.simpan');
            Route::delete('/krs/drop/{id}', [KrsController::class, 'destroy'])->name('krs.drop');
            // Route Baru untuk mengosongkan/reset semua KRS
            Route::post('/krs/reset', [KrsController::class, 'resetKrs'])->name('krs.reset');
            Route::get('/mahasiswa/krs/export-pdf', [KrsController::class, 'exportPdf'])->name('krs.pdf');
        });
});

// 4. Route Auth Bawaan Breeze
require __DIR__.'/auth.php';
