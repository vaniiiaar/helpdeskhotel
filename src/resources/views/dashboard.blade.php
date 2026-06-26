@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- WELCOME --}}
    <div class="card border-0 shadow-lg mb-4"
         style="border-radius:20px;
                background:linear-gradient(135deg,#0f172a,#1e293b);
                color:white;">

        <div class="card-body p-5">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h2 class="fw-bold mb-2">

                        Welcome Back,
                        {{ auth()->user()->name }}

                    </h2>

                    <p class="mb-0 opacity-75">

                        Pullman Jakarta Central Park
                        Internal Helpdesk System

                    </p>

                    <div class="mt-3">

                        @if(auth()->user()->role === 'admin')

                            <span class="badge bg-danger px-3 py-2">
                                ADMIN
                            </span>

                        @elseif(auth()->user()->role === 'staff')

                            <span class="badge bg-warning text-dark px-3 py-2">
                                STAFF
                            </span>

                        @else

                            <span class="badge bg-primary px-3 py-2">
                                USER
                            </span>

                        @endif

                    </div>

                </div>

                <div class="text-end">

                    <h1 class="fw-bold opacity-25"
                        style="font-size:70px;">

                        HELPDESK

                    </h1>

                </div>

            </div>

        </div>

    </div>

    {{-- QUICK ACTION --}}
    <div class="row mb-4 g-3">

        <div class="col-md-4">

            <a href="{{ route('tickets.create') }}"
               class="text-decoration-none">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body text-center p-4">

                        <h1>➕</h1>

                        <h5 class="fw-bold">
                            Create Ticket
                        </h5>

                        <p class="text-muted mb-0">
                            Buat ticket baru
                        </p>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-4">

            <a href="{{ route('tickets.index') }}"
               class="text-decoration-none">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body text-center p-4">

                        <h1>🎫</h1>

                        <h5 class="fw-bold">
                            View Tickets
                        </h5>

                        <p class="text-muted mb-0">
                            Lihat daftar ticket
                        </p>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-4">

            <a href="{{ route('tickets.export.pdf') }}"
               class="text-decoration-none">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body text-center p-4">

                        <h1>📄</h1>

                        <h5 class="fw-bold">
                            Export Report
                        </h5>

                        <p class="text-muted mb-0">
                            Download laporan PDF
                        </p>

                    </div>

                </div>

            </a>

        </div>

    </div>

    {{-- STATISTIC --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Total Ticket
                            </p>

                            <h2 class="fw-bold">
                                {{ $totalTickets }}
                            </h2>

                        </div>

                        <div style="font-size:40px;">
                            🎫
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm bg-danger text-white">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="mb-1">
                                Open
                            </p>

                            <h2 class="fw-bold">
                                {{ $openTickets }}
                            </h2>

                        </div>

                        <div style="font-size:40px;">
                            🚨
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm bg-warning text-dark">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="mb-1">
                                Process
                            </p>

                            <h2 class="fw-bold">
                                {{ $processTickets }}
                            </h2>

                        </div>

                        <div style="font-size:40px;">
                            ⏳
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm bg-success text-white">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="mb-1">
                                Closed
                            </p>

                            <h2 class="fw-bold">
                                {{ $closedTickets }}
                            </h2>

                        </div>

                        <div style="font-size:40px;">
                            ✅
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


<div class="col-lg-4">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-danger text-white border-0 p-4">

            <h5 class="fw-bold mb-0">
                🔥 Urgent Ticket
            </h5>

        </div>

        <div class="card-body">

            @forelse($urgentTickets ?? [] as $ticket)

                <div class="border rounded p-3 mb-3">

                    <div class="d-flex justify-content-between">

                        <strong>
                            {{ $ticket->title }}
                        </strong>

                        <span class="badge bg-danger">
                            HIGH
                        </span>

                    </div>

                    <small class="text-muted">

                        Room:
                        {{ $ticket->room_number }}

                    </small>

                    <br>

                    <small>

                        Status:

                        @if($ticket->status == 'Open')

                            <span class="text-danger">
                                Open
                            </span>

                        @elseif($ticket->status == 'Process')

                            <span class="text-warning">
                                Process
                            </span>

                        @else

                            <span class="text-success">
                                Closed
                            </span>

                        @endif

                    </small>

                </div>

            @empty

                <div class="alert alert-success mb-0">

                    Tidak ada ticket urgent 🎉

                </div>

            @endforelse

        </div>

    </div>

</div>

</div>

@endsection