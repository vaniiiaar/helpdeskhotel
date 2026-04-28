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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Ticket</th>
                <th>No Kamar</th>
                <th>Kategori</th>
                <th>Prioritas</th>
                <th>Judul</th>
                <th>Status</th>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection