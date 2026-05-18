<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | USER DASHBOARD
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'user') {

            $totalTickets = Ticket::where('user_id', $user->id)->count();

            $openTickets = Ticket::where('user_id', $user->id)
                ->where('status', 'Open')
                ->count();

            $processTickets = Ticket::where('user_id', $user->id)
                ->where('status', 'Process')
                ->count();

            $closedTickets = Ticket::where('user_id', $user->id)
                ->where('status', 'Closed')
                ->count();

            $latestTickets = Ticket::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard', compact(
                'totalTickets',
                'openTickets',
                'processTickets',
                'closedTickets',
                'latestTickets'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | STAFF DASHBOARD
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'staff') {

            $totalTickets = Ticket::count();

            $openTickets = Ticket::where('status', 'Open')->count();

            $processTickets = Ticket::where('status', 'Process')->count();

            $closedTickets = Ticket::where('status', 'Closed')->count();

            $latestTickets = Ticket::latest()
                ->take(5)
                ->get();

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

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        $totalTickets = Ticket::count();

        $openTickets = Ticket::where('status', 'Open')->count();

        $processTickets = Ticket::where('status', 'Process')->count();

        $closedTickets = Ticket::where('status', 'Closed')->count();

        $latestTickets = Ticket::latest()
            ->take(5)
            ->get();

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