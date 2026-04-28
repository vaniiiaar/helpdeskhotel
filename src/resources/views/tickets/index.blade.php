@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Ticket Helpdesk Hotel</h2>

    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">
        + Buat Ticket
    </a>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-3">
    <select name="status" onchange="this.form.submit()" class="form-select w-auto">
        <option value="">-- Semua Status --</option>
        <option value="Open">Open</option>
        <option value="Process">Process</option>
        <option value="Closed">Closed</option>
    </select>
</form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Ticket</th>
                <th>No Kamar</th>
                <th>Kategori</th>
                <th>Prioritas</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Assigned Staff</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->ticket_code }}</td>
                <td>{{ $ticket->room_number }}</td>
                <td>{{ $ticket->category }}</td>
                <td>{{ $ticket->priority }}</td>
                <td>{{ $ticket->title }}</td>
                <td>{{ $ticket->status }}</td>
                <td>
                    @if($ticket->status == 'Open')
                        <span class="badge bg-danger">Open</span>
                    @elseif($ticket->status == 'Process')
                        <span class="badge bg-warning text-dark">Process</span>
                    @else
                        <span class="badge bg-success">Closed</span>
                    @endif
                </td>
                <td>
                    @if($ticket->status == 'Open')
                        <span class="badge bg-danger">Open</span>
                    @elseif($ticket->status == 'Process')
                        <span class="badge bg-warning text-dark">Process</span>
                    @else
                        <span class="badge bg-success">Closed</span>
                    @endif
                </td>
                <td>{{ $ticket->assigned_to ?? '-' }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                        Edit
                    </a>

                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Hapus ticket ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection