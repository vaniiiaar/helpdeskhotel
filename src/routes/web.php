<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return redirect()->route('guest.tickets.create');
});


Route::get('/guest/tickets/create', [TicketController::class, 'guestCreate'])
    ->name('guest.tickets.create');

Route::post('/guest/tickets', [TicketController::class, 'guestStore'])
    ->name('guest.tickets.store');

Route::get('/guest/tickets/{code}/status', [TicketController::class, 'guestStatus'])
    ->name('guest.tickets.status');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/api/new-tickets-count', [TicketController::class, 'newTicketsCount'])
    ->middleware('auth')
    ->name('tickets.new.count');

Route::middleware('auth')->group(function () {

    // Ticket resource
    Route::resource('tickets', TicketController::class);

    // Export PDF semua ticket
    Route::get('/tickets-export-pdf', [TicketController::class, 'exportPdf'])
        ->name('tickets.export.pdf');

    // Export PDF single ticket
    Route::get('/tickets/{ticket}/pdf', [TicketController::class, 'exportSinglePdf'])
        ->name('tickets.export.single.pdf');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth bawaan Laravel (login, register, dll)
require __DIR__.'/auth.php';
