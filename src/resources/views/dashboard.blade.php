@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Helpdesk Hotel</h2>

    <!-- CARD STATISTIK -->
    <div class="row g-3">

        <div class="col-md-3">
            <div class="card text-center shadow p-3">
                <h5>Total Ticket</h5>
                <h2>{{ $totalTickets }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow p-3 bg-danger text-white">
                <h5>Open</h5>
                <h2>{{ $openTickets }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow p-3 bg-warning text-dark">
                <h5>Process</h5>
                <h2>{{ $processTickets }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow p-3 bg-success text-white">
                <h5>Closed</h5>
                <h2>{{ $closedTickets }}</h2>
            </div>
        </div>

    </div>

    <!-- TICKET TERBARU -->
    <hr class="my-4">

    <h4>Ticket Terbaru</h4>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Room</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($latestTickets as $ticket)
                <tr>
                    <td>{{ $ticket->ticket_code }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>
                        <span class="badge 
                            {{ $ticket->status == 'Open' ? 'bg-danger' : 
                               ($ticket->status == 'Process' ? 'bg-warning text-dark' : 'bg-success') }}">
                            {{ $ticket->status }}
                        </span>
                    </td>
                    <td>{{ $ticket->room_number }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada ticket</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- 🔥 BERITA / URGENT -->
    <hr class="my-4">

    <h4>🔥 Berita / Ticket Prioritas Tinggi</h4>

    <div class="list-group mt-3">
        @forelse ($urgentTickets as $ticket)
            <div class="list-group-item">
                <h6 class="mb-1">
                    {{ $ticket->title }}
                    <span class="badge bg-danger">HIGH</span>
                </h6>

                <small>
                    Room: {{ $ticket->room_number }} |
                    Status: 
                    <span class="badge 
                        {{ $ticket->status == 'Open' ? 'bg-danger' : 
                           ($ticket->status == 'Process' ? 'bg-warning text-dark' : 'bg-success') }}">
                        {{ $ticket->status }}
                    </span>
                </small>
            </div>
        @empty
            <div class="alert alert-success">
                Tidak ada ticket urgent 🎉
            </div>
        @endforelse
    </div>

</div>
@endsection