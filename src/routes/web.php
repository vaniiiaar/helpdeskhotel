<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController; // ✅ INI WAJIB

Route::get('/', function () {
    return redirect('/login');
});

// ✅ Dashboard pakai controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/notifications', function () {
    return \App\Models\Ticket::latest()->take(5)->get();
})->middleware('auth');

// 🔐 Semua yang butuh login
Route::middleware('auth')->group(function () {

    Route::resource('tickets', TicketController::class);

    Route::get('/tickets-export-pdf', [TicketController::class, 'exportPdf'])
        ->name('tickets.export.pdf');

    Route::get('/tickets/{ticket}/pdf', [TicketController::class, 'exportSinglePdf'])
        ->name('tickets.export.single.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// auth bawaan
require __DIR__.'/auth.php';