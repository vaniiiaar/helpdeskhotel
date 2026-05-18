@extends('layouts.app')

@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Dashboard Helpdesk Hotel
            </h2>

            <p class="text-muted mb-0">
                Selamat datang,
                <strong>{{ auth()->user()->name }}</strong>
            </p>
        </div>

        <div>
            @if(auth()->user()->role === 'admin')

                <span class="badge bg-danger fs-6">
                    ADMIN
                </span>

            @elseif(auth()->user()->role === 'staff')

                <span class="badge bg-warning text-dark fs-6">
                    STAFF
                </span>

            @else

                <span class="badge bg-primary fs-6">
                    USER
                </span>

            @endif
        </div>

    </div>

    {{-- CARD STATISTIK --}}
    <div class="row g-3">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Total Ticket
                    </h6>

                    <h1 class="fw-bold">
                        {{ $totalTickets }}
                    </h1>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm bg-danger text-white h-100">

                <div class="card-body text-center">

                    <h6>
                        Open
                    </h6>

                    <h1 class="fw-bold">
                        {{ $openTickets }}
                    </h1>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm bg-warning text-dark h-100">

                <div class="card-body text-center">

                    <h6>
                        Process
                    </h6>

                    <h1 class="fw-bold">
                        {{ $processTickets }}
                    </h1>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm bg-success text-white h-100">

                <div class="card-body text-center">

                    <h6>
                        Closed
                    </h6>

                    <h1 class="fw-bold">
                        {{ $closedTickets }}
                    </h1>

                </div>

            </div>

        </div>

    </div>

    {{-- TICKET TERBARU --}}
    <div class="card border-0 shadow-sm mt-4">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Ticket Terbaru
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">

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

                                <td>
                                    {{ $ticket->ticket_code }}
                                </td>

                                <td>
                                    {{ $ticket->title }}
                                </td>

                                <td>

                                    @if($ticket->status == 'Open')

                                        <span class="badge bg-danger">
                                            Open
                                        </span>

                                    @elseif($ticket->status == 'Process')

                                        <span class="badge bg-warning text-dark">
                                            Process
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            Closed
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $ticket->room_number }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-4">

                                    Belum ada ticket

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- URGENT TICKET KHUSUS ADMIN & STAFF --}}
    @if(auth()->user()->role !== 'user')

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-header bg-danger text-white">

            <h5 class="mb-0">
                🔥 Ticket Prioritas Tinggi
            </h5>

        </div>

        <div class="card-body">

            @forelse ($urgentTickets as $ticket)

                <div class="border-bottom pb-3 mb-3">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="mb-1 fw-bold">

                                {{ $ticket->title }}

                            </h6>

                            <small class="text-muted">

                                Room:
                                {{ $ticket->room_number }}

                            </small>

                        </div>

                        <div>

                            @if($ticket->status == 'Open')

                                <span class="badge bg-danger">
                                    Open
                                </span>

                            @elseif($ticket->status == 'Process')

                                <span class="badge bg-warning text-dark">
                                    Process
                                </span>

                            @else

                                <span class="badge bg-success">
                                    Closed
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="alert alert-success mb-0">

                    Tidak ada ticket urgent 🎉

                </div>

            @endforelse

        </div>

    </div>

    @endif

</div>

@endsection