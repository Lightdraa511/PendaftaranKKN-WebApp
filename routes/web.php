<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfileController;
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

// Landing Page
Route::get('/', [DashboardController::class, 'landing'])->name('landing');

// Auth Routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// API untuk mendapatkan program studi berdasarkan fakultas
Route::get('/api/program-studi/{fakultas_id}', [AuthController::class, 'getProgramStudi']);

// API untuk mendapatkan daftar fakultas
Route::get('/api/fakultas', [App\Http\Controllers\ApiController::class, 'getAllFakultas'])->name('api.fakultas');

// Midtrans Notification
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

// Protected Routes (Authentication Required)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update_photo');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');
    Route::get('/profile/program-studi', [ProfileController::class, 'getProgramStudi'])->name('profile.get_program_studi');

    // Lokasi KKNM
    Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::get('/lokasi/{id}', [LokasiController::class, 'show'])->name('lokasi.show');
    Route::post('/lokasi/{id}/select', [LokasiController::class, 'select'])->name('lokasi.select');
    // web.php - tambahkan route untuk detail lokasi
    Route::get('/lokasi/{id}/detail', [LokasiController::class, 'detail'])->name('lokasi.detail');

    // Pembayaran Routes
    Route::middleware('auth')->group(function () {
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran/process', [PembayaranController::class, 'process'])->name('pembayaran.process');
        Route::get('/pembayaran/finish', [PembayaranController::class, 'finish'])->name('pembayaran.finish');
        Route::get('/pembayaran/{id}/check-status', [PembayaranController::class, 'checkStatus'])->name('pembayaran.check_status');
    });

    // Pendaftaran
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Bantuan
    Route::get('/bantuan', [DashboardController::class, 'help'])->name('help');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin auth routes
    Route::get('/login', [App\Http\Controllers\AdminAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\AdminAuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('logout');

    // Admin protected routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');

        // Kelola Mahasiswa
        Route::get('/mahasiswa', [App\Http\Controllers\AdminUserController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/create', [App\Http\Controllers\AdminUserController::class, 'create'])->name('mahasiswa.create');
        Route::post('/mahasiswa', [App\Http\Controllers\AdminUserController::class, 'store'])->name('mahasiswa.store');
        Route::get('/mahasiswa/{id}', [App\Http\Controllers\AdminUserController::class, 'show'])->name('mahasiswa.show');
        Route::get('/mahasiswa/{id}/edit', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/{id}', [App\Http\Controllers\AdminUserController::class, 'update'])->name('mahasiswa.update');
        Route::delete('/mahasiswa/{id}', [App\Http\Controllers\AdminUserController::class, 'destroy'])->name('mahasiswa.destroy');
        Route::get('/api/program-studi/{fakultas_id}', [App\Http\Controllers\AdminUserController::class, 'getProgramStudi'])->name('program-studi.get');

        // Kelola Lokasi KKN
        Route::get('/lokasi', [App\Http\Controllers\AdminLokasiController::class, 'index'])->name('lokasi.index');
        Route::get('/lokasi/create', [App\Http\Controllers\AdminLokasiController::class, 'create'])->name('lokasi.create');
        Route::post('/lokasi', [App\Http\Controllers\AdminLokasiController::class, 'store'])->name('lokasi.store');
        Route::get('/lokasi/{id}', [App\Http\Controllers\AdminLokasiController::class, 'show'])->name('lokasi.show');
        Route::get('/lokasi/{id}/edit', [App\Http\Controllers\AdminLokasiController::class, 'edit'])->name('lokasi.edit');
        Route::put('/lokasi/{id}', [App\Http\Controllers\AdminLokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/lokasi/{id}', [App\Http\Controllers\AdminLokasiController::class, 'destroy'])->name('lokasi.destroy');
        Route::delete('/lokasi/kuota/{id}', [App\Http\Controllers\AdminLokasiController::class, 'deleteKuota'])->name('lokasi.delete-kuota');

        // Kelola Pembayaran
        Route::get('/payment', [App\Http\Controllers\AdminPaymentController::class, 'index'])->name('payment.index');
        Route::get('/payment/{id}', [App\Http\Controllers\AdminPaymentController::class, 'show'])->name('payment.show');
        Route::put('/payment/{id}/verify', [App\Http\Controllers\AdminPaymentController::class, 'verify'])->name('payment.verify');
        Route::put('/payment/{id}/reject', [App\Http\Controllers\AdminPaymentController::class, 'reject'])->name('payment.reject');
    });
});
