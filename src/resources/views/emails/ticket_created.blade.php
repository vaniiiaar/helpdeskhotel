<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Ticket Baru</title>
    </head>
    <body>
        <h2>Ticket Baru Dibuat</h2>

        <p>
            <strong>Ticket Code:</strong>
            {{ $ticket->ticket_code }}
        </p>
        <p>
            <strong>Room Number:</strong>
            {{ $ticket->room_number }}
        </p>
        <p>
            <strong>Category:</strong>
            {{ $ticket->category }}
        </p>
        <p>
            <strong>Priority:</strong>
            {{ $ticket->priority }}
        </p>
        <p>
            <strong>Title:</strong>
            {{ $ticket->title }}
        </p>
        <p>
            <strong>Description:</strong>
            {{ $ticket->description }}
        </p>
        <p>
            <strong>Status:</strong>
            {{ $ticket->status }}
        </p>

        <br />

        <p>Helpdesk Hotel System</p>
    </body>
</html>
