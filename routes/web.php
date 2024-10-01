<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return redirect(route('guest.reservations'));
//});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Guest-facing routes
Route::get('/reservations', [GuestController::class, 'index'])->name('guest.reservations');
Route::post('/reservations/search', [GuestController::class, 'searchRooms'])->name('guest.reservations.search');
Route::post('/reservations/store', [GuestController::class, 'storeReservation'])->name('guest.reservations.store');

Route::get('/', [GuestController::class, 'showReservationForm'])->name('home');
Route::post('/rooms/available', [ReservationController::class, 'filterAvailableRooms'])->name('rooms.available');
Route::get('/rooms/available', [ReservationController::class, 'availableRooms'])->name('rooms.show');
Route::post('/checkout', [ReservationController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{room}', [ReservationController::class, 'showCheckout'])->name('checkout.show');
Route::post('/reservation/confirm', [ReservationController::class, 'confirm'])->name('reservation.confirm');
Route::get('/payment', [ReservationController::class, 'showPaymentPage'])->name('payment.show');
Route::post('/payment/process', [ReservationController::class, 'processPayment'])->name('payment.process');
Route::get('/reservation/success/{reservation}', [ReservationController::class, 'showSuccessPage'])->name('reservation.success');

Route::post('/reservation/cancel/{reservation}', [ReservationController::class, 'cancelReservation'])->name('reservation.cancel');
Route::post('/payment/cancel', [ReservationController::class, 'cancelPayment'])->name('payment.cancel');

// Admin-facing routes (with middleware for admin users)
//Route::middleware('auth')->prefix('admin')->group(function () {
//    Route::get('/reservations', [AdminController::class, 'index'])->name('admin.reservations');
//    Route::get('/reservations/{id}', [AdminController::class, 'showReservation'])->name('admin.reservations.show');
//});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
    Route::get('/admin/upcoming-reservations', [AdminController::class, 'upcomingReservations'])->name('admin.upcoming');
    Route::post('/admin/reservations/{reservation}/mark-done', [AdminController::class, 'markAsDone']);
    Route::post('/admin/reservations/{reservation}/mark-checked-in', [AdminController::class, 'markAsCheckedIn']);

});
