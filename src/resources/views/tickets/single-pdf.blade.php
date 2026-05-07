<!DOCTYPE html>
<html>
    <head>
        <title>Detail Ticket</title>
        <style>
            body {
                font-family: sans-serif;
            }
            img {
                width: 250px;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <h2>Detail Ticket</h2>

        <p>Kode: {{ $ticket->ticket_code }}</p>
        <p>Kamar: {{ $ticket->room_number }}</p>
        <p>Kategori: {{ $ticket->category }}</p>
        <p>Prioritas: {{ $ticket->priority }}</p>
        <p>Status: {{ $ticket->status }}</p>

        <hr />

        <h4>Keluhan</h4>
        <p>{{ $ticket->description }}</p>

        <h4>Report</h4>
        <p>{{ $ticket->report ?? '-' }}</p>

        @if ($ticket->photo)
            <h4>Foto</h4>
            <img src="{{ public_path('storage/' . $ticket->photo) }}" />
        @endif
    </body>
</html>
