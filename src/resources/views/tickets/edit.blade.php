@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Ticket</h2>

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nomor Kamar</label>
            <input type="text" name="room_number" class="form-control"
                value="{{ old('room_number', $ticket->room_number) }}" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="category" class="form-control" required>
                <option value="Housekeeping" {{ $ticket->category == 'Housekeeping' ? 'selected' : '' }}>Housekeeping</option>
                <option value="Engineering" {{ $ticket->category == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                <option value="IT Support" {{ $ticket->category == 'IT Support' ? 'selected' : '' }}>IT Support</option>
                <option value="Room Service" {{ $ticket->category == 'Room Service' ? 'selected' : '' }}>Room Service</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Priority</label>
            <select name="priority" class="form-control" required>
                <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Assign To (Staff)</label>
            <input type="text" name="assigned_to" class="form-control"
                value="{{ old('assigned_to', $ticket->assigned_to) }}">
        </div>

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control"
                value="{{ old('title', $ticket->title) }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $ticket->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                <option value="Process" {{ $ticket->status == 'Process' ? 'selected' : '' }}>Process</option>
                <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Laporan Penyelesaian</label>
            <textarea name="report" class="form-control" rows="3">{{ old('report', $ticket->report) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Upload Foto</label>
            <input type="file" name="photo" class="form-control">
        </div>

        {{-- preview foto --}}
        @if ($ticket->photo)
            <div class="mb-3">
                <label>Foto Saat Ini</label><br>
                <img src="{{ asset('storage/'.$ticket->photo) }}" width="200">
            </div>
        @endif

        <button type="submit" class="btn btn-success">Update Ticket</button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection