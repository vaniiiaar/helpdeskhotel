<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    // LIST TICKET
    public function index(Request $request)
    {
        $query = Ticket::query();

        // FILTER STATUS
        if ($request->status) {

            $query->where('status', $request->status);

        }

        // USER hanya lihat ticket sendiri
        if (auth()->user()->role === 'user') {

            $query->where('user_id', auth()->id());

        }

        $tickets = $query->latest()->get();

        return view('tickets.index', compact('tickets'));
    }

    // FORM CREATE
    public function create()
    {
        return view('tickets.create');
    }

    // DETAIL TICKET
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    // SIMPAN TICKET
    public function store(Request $request)
    {
        $request->validate([

            'room_number' => 'required',
            'category'    => 'required',
            'priority'    => 'required',
            'title'       => 'required',
            'description' => 'required',

        ]);

        Ticket::create([

            'user_id' => auth()->id(),

            'ticket_code' =>
                'TCK-' . strtoupper(uniqid()),

            'room_number' =>
                $request->room_number,

            'category' =>
                $request->category,

            'priority' =>
                $request->priority,

            'title' =>
                $request->title,

            'description' =>
                $request->description,

            'status' =>
                'Open',

            'assigned_to' =>
                $request->assigned_to,

        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket berhasil dibuat');
    }


    public function edit(Ticket $ticket)
    {
        if (auth()->user()->role === 'user') {

            abort(403);

        }
        return view('tickets.edit', compact('ticket'));
    }

    // UPDATE TICKET
    public function update(Request $request, Ticket $ticket)
    {
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

        // UPLOAD FOTO
        if ($request->hasFile('photo')) {

            $photoPath = $request
                ->file('photo')
                ->store('reports', 'public');

            $ticket->report_photo = $photoPath;
        }

        $ticket->update([

            'room_number' =>
                $request->room_number,

            'category' =>
                $request->category,

            'priority' =>
                $request->priority,

            'title' =>
                $request->title,

            'description' =>
                $request->description,

            'status' =>
                $request->status,

            'assigned_to' =>
                $request->assigned_to,

            'report' =>
                $request->report,

        ]);

        // SAVE FOTO
        if ($request->hasFile('photo')) {

            $ticket->save();

        }

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket berhasil diupdate');
    }

    // DELETE
    public function destroy(Ticket $ticket)
    {
        // hanya admin
        if (auth()->user()->role !== 'admin') {

            abort(403);

        }

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket berhasil dihapus');
    }

    // EXPORT SEMUA PDF
    public function exportPdf()
    {
        $tickets = Ticket::all();

        $pdf = Pdf::loadView(
            'tickets.pdf',
            compact('tickets')
        );

        return $pdf->download('tickets.pdf');
    }

    // EXPORT SINGLE PDF
    public function exportSinglePdf(Ticket $ticket)
    {
        $pdf = Pdf::loadView(
            'tickets.single-pdf',
            compact('ticket')
        );

        return $pdf->download(
            'ticket-' . $ticket->ticket_code . '.pdf'
        );
    }
}