@extends('layouts.app')

@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            Detail Ticket

        </h2>

        <a href="{{ route('tickets.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

    {{-- CARD --}}
    <div class="card shadow-sm border-0">

        <div class="card-body">

            {{-- KODE --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Kode Ticket
                </h5>

                <p>
                    {{ $ticket->ticket_code }}
                </p>

            </div>

            {{-- ROOM --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Nomor Kamar
                </h5>

                <p>
                    {{ $ticket->room_number }}
                </p>

            </div>

            {{-- CATEGORY --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Kategori
                </h5>

                <p>
                    {{ $ticket->category }}
                </p>

            </div>

            {{-- PRIORITY --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Priority
                </h5>

                @if($ticket->priority == 'Urgent')

                    <span class="badge bg-danger">
                        Urgent
                    </span>

                @elseif($ticket->priority == 'High')

                    <span class="badge bg-warning text-dark">
                        High
                    </span>

                @elseif($ticket->priority == 'Medium')

                    <span class="badge bg-primary">
                        Medium
                    </span>

                @else

                    <span class="badge bg-success">
                        Low
                    </span>

                @endif

            </div>

            {{-- JUDUL --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Judul
                </h5>

                <p>
                    {{ $ticket->title }}
                </p>

            </div>

            {{-- DESKRIPSI --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Deskripsi
                </h5>

                <div class="border rounded p-3 bg-light">

                    {{ $ticket->description }}

                </div>

            </div>

            {{-- STATUS --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Status
                </h5>

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

            {{-- ASSIGNED --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Assigned Staff
                </h5>

                <p>
                    {{ $ticket->assigned_to ?? '-' }}
                </p>

            </div>

            {{-- REPORT --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Laporan Penyelesaian
                </h5>

                <div class="border rounded p-3 bg-light">

                    {{ $ticket->report ?? 'Belum ada laporan' }}

                </div>

            </div>

            {{-- FOTO --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Foto Penyelesaian
                </h5>

                @if($ticket->report_photo)

                    <img src="{{ asset('storage/' . $ticket->report_photo) }}"
                         class="img-fluid rounded shadow"
                         width="400">

                @else

                    <p class="text-muted">
                        Belum ada foto
                    </p>

                @endif

            </div>

            {{-- CREATED --}}
            <div class="mb-4">

                <h5 class="fw-bold">
                    Dibuat Pada
                </h5>

                <p>
                    {{ $ticket->created_at }}
                </p>

            </div>

            {{-- BUTTON --}}
            <div class="d-flex gap-2">

                <a href="{{ route('tickets.edit', $ticket->id) }}"
                   class="btn btn-primary">

                    Edit Ticket

                </a>

                <a href="{{ route('tickets.export.single.pdf', $ticket->id) }}"
                   class="btn btn-danger">

                    Export PDF

                </a>

            </div>

        </div>

    </div>

</div>

@endsection