<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::latest()->get();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required',
            'category' => 'required',
            'priority' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        Ticket::create([
            'ticket_code' => 'TCK-' . time(),
            'user_id' => Auth::id(),
            'room_number' => $request->room_number,
            'category' => $request->category,
            'priority' => $request->priority,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Open',
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket berhasil dibuat.');
    }
}