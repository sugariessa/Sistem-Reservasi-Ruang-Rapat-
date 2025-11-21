<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landing');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/rooms', [\App\Http\Controllers\AdminController::class, 'rooms'])->name('admin.rooms');
    Route::get('/admin/reservations', [\App\Http\Controllers\AdminController::class, 'reservations'])->name('admin.reservations');
    Route::get('/admin/schedule', [\App\Http\Controllers\AdminController::class, 'schedule'])->name('admin.schedule');
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    
    Route::resource('rooms', RoomController::class);
    Route::post('/admin/reservations/{id}/terima', [AdminReservationController::class, 'terima'])->name('admin.reservations.terima');
    Route::post('/admin/reservations/{id}/tolak', [AdminReservationController::class, 'tolak'])->name('admin.reservations.tolak');
    Route::post('/admin/schedule', [\App\Http\Controllers\AdminController::class, 'storeSchedule'])->name('admin.schedule.store');
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [ReservationController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/rooms', [ReservationController::class, 'rooms'])->name('user.rooms');
    Route::get('/user/reservations', [ReservationController::class, 'index'])->name('user.reservations');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('/reservations/schedule/check', [ReservationController::class, 'getSchedule'])->name('reservations.schedule');
});

