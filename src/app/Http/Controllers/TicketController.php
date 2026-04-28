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
    public function index(Request $request)
    {
        $query = Ticket::latest();
        if ($request->status) {
        $query->where('status', $request->status);
        }
        
        $tickets = $query->get();
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
        $validated = $request->validate([
            'room_number' => 'required|string|max:10',
            'category' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Ticket::create([
            'ticket_code' => 'TCK-' . time(),
            'user_id' => Auth::id(),
            'room_number' => $validated['room_number'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'Open',
            'assigned_to' => null,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'room_number' => 'required|string|max:10',
            'category' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:Open,Process,Closed',
            'assigned_to' => 'nullable|string',
            'report' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload foto jika ada
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('tickets', 'public');
            $data['photo'] = $path;
        }

        $ticket->update($data);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket berhasil dihapus.');
    }
}