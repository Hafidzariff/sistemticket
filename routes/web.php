<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// =======================
// USER (TANPA LOGIN)
// =======================
Route::get('/', [ReportController::class, 'create'])->name('home');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports/store', [ReportController::class, 'store'])->name('reports.store');

// =======================
// AUTH ADMIN
// =======================
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.process');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// =======================
// ADMIN AREA (PROTECTED)
// =======================
Route::middleware(['admin.auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::delete('/reports/destroy-all', [ReportController::class, 'destroyAll'])->name('reports.destroyAll');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// =======================
// TEST ROUTES (DEBUG)
// =======================

// Test koneksi database
Route::get('/db-test', function () {
    return DB::select('SELECT 1');
});

// Test insert ke database (AIVEN)
Route::get('/insert-test', function () {
    DB::table('reports')->insert([
        'nama_pelapor'      => 'Test dari Vercel',
        'departemen'        => 'IT',
        'tanggal_laporan'   => now()->toDateString(),
        'jenis_masalah'     => 'Testing',
        'deskripsi'         => 'Insert database dari Vercel berhasil',
        'status'            => 'Baru',
        'created_at'        => now(),
        'updated_at'        => now(),
    ]);

    return 'insert OK';
});
