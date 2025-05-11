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

// Midtrans Notification
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

// Protected Routes (Authentication Required)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');
    Route::get('/profile/program-studi', [ProfileController::class, 'getProgramStudi'])->name('profile.get_program_studi');

    // Lokasi KKNM
    Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::get('/lokasi/{id}', [LokasiController::class, 'show'])->name('lokasi.show');
    Route::post('/lokasi/{id}/select', [LokasiController::class, 'select'])->name('lokasi.select');

    // Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/process', [PembayaranController::class, 'process'])->name('pembayaran.process');
    Route::get('/pembayaran/{id}/check', [PembayaranController::class, 'check'])->name('pembayaran.check');
    Route::post('/pembayaran/callback', [PembayaranController::class, 'callback'])->name('pembayaran.callback');

    // Midtrans Notification (tidak perlu login)
    Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

    // Pendaftaran
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Bantuan
    Route::get('/bantuan', [DashboardController::class, 'help'])->name('help');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin auth routes akan ditambahkan nanti
});