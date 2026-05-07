<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Laporan Ticket</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table,
            th,
            td {
                border: 1px solid black;
                padding: 8px;
            }

            th {
                background: #f2f2f2;
            }

            h2 {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h2>Laporan Ticket Helpdesk Hotel</h2>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Ticket Code</th>
                    <th>Room</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Assigned Staff</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ticket->ticket_code }}</td>
                        <td>{{ $ticket->room_number }}</td>
                        <td>{{ $ticket->category }}</td>
                        <td>{{ $ticket->priority }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td>{{ $ticket->assigned_to ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
