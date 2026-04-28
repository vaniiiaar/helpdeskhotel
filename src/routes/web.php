<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Models\Ticket;  

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    $totalTickets = Ticket::count();
    $openTickets = Ticket::where('status', 'Open')->count();
    $progressTickets = Ticket::where('status', 'Progress')->count();
    $doneTickets = Ticket::where('status', 'Done')->count();

    return view('dashboard', compact(
        'totalTickets',
        'openTickets',
        'progressTickets',
        'doneTickets'
    ));
})->name('dashboard');

Route::resource('tickets', TicketController::class);