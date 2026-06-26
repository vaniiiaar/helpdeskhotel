<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketTimeline;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    // ======================================================
    // GUEST - FORM CREATE (Customer tanpa login)
    // ======================================================
    public function guestCreate()
    {
        return view('guest.create');
    }

    // ======================================================
    // GUEST - STORE TICKET (Customer tanpa login)
    // ======================================================
    public function guestStore(Request $request)
    {
        $request->validate([
            'guest_name'  => 'required|string|max:100',
            'room_number' => 'required|string|max:20',
            'category'    => 'required',
            'priority'    => 'required',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Cari atau buat user guest berdasarkan nama + kamar
        $guestUser = \App\Models\User::firstOrCreate(
            ['email' => 'guest_room' . strtolower(str_replace(' ', '', $request->room_number)) . '@hotel.com'],
            [
                'name'     => $request->guest_name,
                'password' => bcrypt('guest123'),
                'role'     => 'user',
            ]
        );

        // Buat ticket
        $ticket = Ticket::create([
            'user_id'     => $guestUser->id,
            'ticket_code' => 'TCK-' . strtoupper(uniqid()),
            'room_number' => $request->room_number,
            'category'    => $request->category,
            'priority'    => $request->priority,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'Open',
        ]);

        // Timeline
        TicketTimeline::create([
            'ticket_id' => $ticket->id,
            'activity'  => 'Ticket dibuat oleh tamu ' . $request->guest_name . ' dari kamar ' . $request->room_number,
        ]);

        return redirect()
            ->route('guest.tickets.status', $ticket->ticket_code)
            ->with('ticket_created', true);
    }

    // ======================================================
    // GUEST - CEK STATUS TICKET
    // ======================================================
    public function guestStatus($code)
    {
        $ticket = Ticket::where('ticket_code', $code)->firstOrFail();
        return view('guest.status', compact('ticket'));
    }

    // ======================================================
    // API - COUNT TIKET BARU (Polling notif staff & admin)
    // ======================================================
    public function newTicketsCount()
    {
        // Hanya untuk staff & admin
        if (auth()->user()->role === 'user') {
            return response()->json(['count' => 0, 'tickets' => []]);
        }

        $lastSeenId = session('last_seen_ticket_id', 0);

        $newTickets = Ticket::where('id', '>', $lastSeenId)
            ->latest()
            ->get();

        // Update session ke ID ticket terbaru
        $latestId = Ticket::max('id');
        if ($latestId) {
            session(['last_seen_ticket_id' => $latestId]);
        }

        return response()->json([
            'count'   => $newTickets->count(),
            'tickets' => $newTickets->map(fn($t) => [
                'id'          => $t->id,
                'code'        => $t->ticket_code,
                'title'       => $t->title,
                'room_number' => $t->room_number,
                'priority'    => $t->priority,
                'category'    => $t->category,
            ]),
        ]);
    }

    // ======================================================
    // LIST TICKET
    // ======================================================
    public function index(Request $request)
    {
        // Admin & Staff: lihat semua ticket
        if (
            auth()->user()->role === 'admin' ||
            auth()->user()->role === 'staff'
        ) {
            $query = Ticket::query();
        }
        // User: hanya lihat ticket sendiri
        else {
            $query = Ticket::where('user_id', auth()->id());
        }

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->get();

        return view('tickets.index', compact('tickets'));
    }

    // ======================================================
    // FORM CREATE (user yang login)
    // ======================================================
    public function create()
    {
        return view('tickets.create');
    }

    // ======================================================
    // STORE TICKET (user yang login)
    // ======================================================
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required',
            'category'    => 'required',
            'priority'    => 'required',
            'title'       => 'required',
            'description' => 'required',
        ]);

        $ticket = Ticket::create([
            'user_id'     => auth()->id(),
            'ticket_code' => 'TCK-' . strtoupper(uniqid()),
            'room_number' => $request->room_number,
            'category'    => $request->category,
            'priority'    => $request->priority,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'Open',
            'assigned_to' => $request->assigned_to,
        ]);

        TicketTimeline::create([
            'ticket_id' => $ticket->id,
            'activity'  => 'Ticket dibuat oleh ' . auth()->user()->name,
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('ticket_created', true);
    }

    // ======================================================
    // DETAIL TICKET
    // ======================================================
    public function show(Ticket $ticket)
    {
        // User hanya boleh lihat ticket sendiri
        if (
            auth()->user()->role === 'user' &&
            $ticket->user_id !== auth()->id()
        ) {
            abort(403);
        }

        return view('tickets.show', compact('ticket'));
    }

    // ======================================================
    // FORM EDIT
    // ======================================================
    public function edit(Ticket $ticket)
    {
        // User tidak boleh edit
        if (auth()->user()->role === 'user') {
            abort(403);
        }

        return view('tickets.edit', compact('ticket'));
    }

    // ======================================================
    // UPDATE TICKET
    // ======================================================
    public function update(Request $request, Ticket $ticket)
    {
        // User tidak boleh update
        if (auth()->user()->role === 'user') {
            abort(403);
        }

        $request->validate([
            'room_number' => 'required',
            'category'    => 'required',
            'priority'    => 'required',
            'title'       => 'required',
            'description' => 'required',
            'status'      => 'required',
        ]);

        // Upload foto
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reports', 'public');
            $ticket->report_photo = $photoPath;
        }

        $oldStatus = $ticket->status;

        // Update data
        $ticket->update([
            'room_number' => $request->room_number,
            'category'    => $request->category,
            'priority'    => $request->priority,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
            'assigned_to' => $request->assigned_to,
            'report'      => $request->report,
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            $ticket->save();
        }

        // Timeline jika status berubah
        if ($oldStatus != $request->status) {
            TicketTimeline::create([
                'ticket_id' => $ticket->id,
                'activity'  => 'Status ticket diubah menjadi ' . $request->status . ' oleh ' . auth()->user()->name,
            ]);
        }

        // Notif Process
        if ($request->status == 'Process') {
            return redirect()
                ->route('tickets.index')
                ->with('ticket_process', true);
        }

        // Notif Closed
        if ($request->status == 'Closed') {
            return redirect()
                ->route('tickets.index')
                ->with('ticket_closed', true);
        }

        // Default
        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket berhasil diupdate');
    }

    // ======================================================
    // DELETE (Admin only)
    // ======================================================
    public function destroy(Ticket $ticket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket berhasil dihapus');
    }

    // ======================================================
    // EXPORT ALL PDF
    // ======================================================
    public function exportPdf()
    {
        $tickets = Ticket::all();
        $pdf = Pdf::loadView('tickets.pdf', compact('tickets'));
        return $pdf->download('tickets.pdf');
    }

    // ======================================================
    // EXPORT SINGLE PDF
    // ======================================================
    public function exportSinglePdf(Ticket $ticket)
    {
        $pdf = Pdf::loadView('tickets.single-pdf', compact('ticket'));
        return $pdf->download('ticket-' . $ticket->ticket_code . '.pdf');
    }
}
