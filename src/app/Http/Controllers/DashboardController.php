<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        // statistik
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'Open')->count();
        $processTickets = Ticket::where('status', 'Process')->count();
        $closedTickets = Ticket::where('status', 'Closed')->count();

        // ticket terbaru
        $latestTickets = Ticket::latest()->take(5)->get();

        // 🔥 BERITA (urgent)
        $urgentTickets = Ticket::where('priority', 'High')
            ->where('status', '!=', 'Closed')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTickets',
            'openTickets',
            'processTickets',
            'closedTickets',
            'latestTickets',
            'urgentTickets'
        ));
    }
}