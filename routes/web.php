<?php
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\BookingController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookingController::class, 'home'])->name('home');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{reference}', [BookingController::class, 'show'])->name('booking.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(AdminAuth::class)->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', fn () => redirect()->route('admin.reservations.index'));
        Route::resource('reservations', ReservationController::class)->except(['create', 'store', 'show']);
        Route::resource('tables', TableController::class)->except(['show'])->parameters(['tables' => 'table']);
    });
});
