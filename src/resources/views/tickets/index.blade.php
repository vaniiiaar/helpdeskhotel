@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            Daftar Ticket Helpdesk Hotel
        </h2>

        <div class="d-flex gap-2">

            <a href="{{ route('tickets.create') }}"
               class="btn btn-primary">

                + Buat Ticket

            </a>

            <a href="{{ route('tickets.export.pdf') }}"
               class="btn btn-success">

                Export PDF

            </a>

        </div>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    {{-- FILTER --}}
    <form method="GET"
          class="mb-3">

        <select name="status"
                onchange="this.form.submit()"
                class="form-select w-auto">

            <option value="">
                -- Semua Status --
            </option>

            <option value="Open"
                {{ request('status') == 'Open' ? 'selected' : '' }}>

                Open

            </option>

            <option value="Process"
                {{ request('status') == 'Process' ? 'selected' : '' }}>

                Process

            </option>

            <option value="Closed"
                {{ request('status') == 'Closed' ? 'selected' : '' }}>

                Closed

            </option>

        </select>

    </form>

    {{-- TABLE --}}
    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>Kode Ticket</th>
                        <th>No Kamar</th>
                        <th>Kategori</th>
                        <th>Priority</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th width="250">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($tickets as $ticket)

                        <tr>

                            <td>
                                {{ $ticket->ticket_code }}
                            </td>

                            <td>
                                {{ $ticket->room_number }}
                            </td>

                            <td>
                                {{ $ticket->category }}
                            </td>

                            <td>

                                @if($ticket->priority == 'High')

                                    <span class="badge bg-danger">
                                        High
                                    </span>

                                @elseif($ticket->priority == 'Medium')

                                    <span class="badge bg-warning text-dark">
                                        Medium
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Low
                                    </span>

                                @endif

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

                                {{ $ticket->assigned_to ?? '-' }}

                            </td>

                            <td class="d-flex gap-2">
                                <a href="{{ route('tickets.show', $ticket->id) }}"
                                class="btn btn-sm btn-info text-white"> 
                                Detail
                                </a>

                                {{-- EDIT --}}
                                @if(auth()->user()->role !== 'user')
                            <a href="{{ route('tickets.edit', $ticket->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                
                                Edit
                            </a>
                            @endif

                                {{-- PDF --}}
                                <a href="{{ route('tickets.export.single.pdf', $ticket->id) }}"
                                   class="btn btn-sm btn-danger">

                                    PDF

                                </a>

                                {{-- DELETE --}}
                                @if(auth()->user()->role === 'admin')

                                <form action="{{ route('tickets.destroy', $ticket->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger">
                                        Hapus
                                    </button>

                                </form>

@endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center">

                                Tidak ada ticket

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection