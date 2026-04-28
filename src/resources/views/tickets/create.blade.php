@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Buat Ticket Baru</h2>

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>No Kamar</label>
            <input type="text" name="room_number" class="form-control">
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="category" class="form-control">
                <option>Housekeeping</option>
                <option>Maintenance</option>
                <option>Engineering</option>
                <option>IT Support</option>
                <option>Security</option>
                <option>Front Office</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Prioritas</label>
            <select name="priority" class="form-control">
                <option>Low</option>
                <option>Medium</option>
                <option>High</option>
                <option>Urgent</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Judul Masalah</label>
            <input type="text" name="title" class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">
            Simpan Ticket
        </button>
    </form>
</div>
@endsection