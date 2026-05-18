<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Ticket Report</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #222;
            font-size: 13px;
            line-height: 1.6;
        }

        .header {
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 3px solid #1f2937;
            padding-bottom: 15px;
        }

        .logo {
            width: 220px;
            height: auto;
        }

        .hotel-name {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
            margin-top: 10px;
        }

        .subtitle {
            color: #6b7280;
            font-size: 13px;
        }

        .report-title {
            margin-top: 20px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #111827;
        }

        .report-code {
            text-align: center;
            color: #6b7280;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 18px;
        }

        .label {
            font-weight: bold;
            color: #111827;
            margin-bottom: 5px;
        }

        .box {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px;
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
            font-weight: bold;
        }

        .badge-open {
            background: #dc2626;
        }

        .badge-process {
            background: #f59e0b;
        }

        .badge-closed {
            background: #16a34a;
        }

        .badge-low {
            background: #16a34a;
        }

        .badge-medium {
            background: #2563eb;
        }

        .badge-high {
            background: #dc2626;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            vertical-align: top;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            border-top: 1px solid #d1d5db;
            padding-top: 10px;
        }

        .signature {
            margin-top: 70px;
            width: 100%;
        }

        .signature td {
            text-align: center;
        }

        .sign-box {
            padding-top: 60px;
            font-weight: bold;
        }

    </style>

</head>

<body>

    {{-- HEADER --}}
    <div class="header">

        <img src="{{ public_path('images/logohijau.png') }}"
             class="logo">

        <div class="hotel-name">
            Pullman Jakarta Central Park
        </div>

        <div class="subtitle">
            Internal Helpdesk Management System
        </div>

    </div>

    {{-- TITLE --}}
    <div class="report-title">
        TICKET REPORT
    </div>

    <div class="report-code">
        {{ $ticket->ticket_code }}
    </div>

    {{-- INFO --}}
    <table>

        <tr>

            <td width="50%">

                <div class="section">

                    <div class="label">
                        Room Number
                    </div>

                    <div class="box">
                        {{ $ticket->room_number }}
                    </div>

                </div>

            </td>

            <td width="50%">

                <div class="section">

                    <div class="label">
                        Category
                    </div>

                    <div class="box">
                        {{ $ticket->category }}
                    </div>

                </div>

            </td>

        </tr>

        <tr>

            <td>

                <div class="section">

                    <div class="label">
                        Priority
                    </div>

                    <div class="box">

                        @if($ticket->priority == 'High')

                            <span class="badge badge-high">
                                HIGH
                            </span>

                        @elseif($ticket->priority == 'Medium')

                            <span class="badge badge-medium">
                                MEDIUM
                            </span>

                        @else

                            <span class="badge badge-low">
                                LOW
                            </span>

                        @endif

                    </div>

                </div>

            </td>

            <td>

                <div class="section">

                    <div class="label">
                        Status
                    </div>

                    <div class="box">

                        @if($ticket->status == 'Open')

                            <span class="badge badge-open">
                                OPEN
                            </span>

                        @elseif($ticket->status == 'Process')

                            <span class="badge badge-process">
                                PROCESS
                            </span>

                        @else

                            <span class="badge badge-closed">
                                CLOSED
                            </span>

                        @endif

                    </div>

                </div>

            </td>

        </tr>

    </table>

    {{-- TITLE --}}
    <div class="section">

        <div class="label">
            Ticket Title
        </div>

        <div class="box">
            {{ $ticket->title }}
        </div>

    </div>

    {{-- DESCRIPTION --}}
    <div class="section">

        <div class="label">
            Description
        </div>

        <div class="box">
            {{ $ticket->description }}
        </div>

    </div>

    {{-- ASSIGNED --}}
    <div class="section">

        <div class="label">
            Assigned Staff
        </div>

        <div class="box">
            {{ $ticket->assigned_to ?? '-' }}
        </div>

    </div>

    {{-- REPORT --}}
    <div class="section">

        <div class="label">
            Completion Report
        </div>

        <div class="box">
            {{ $ticket->report ?? 'No completion report yet.' }}
        </div>

    </div>

    {{-- PHOTO --}}
    @if($ticket->report_photo)

        <div class="section">

            <div class="label">
                Completion Photo
            </div>

            <img src="{{ public_path('storage/' . $ticket->report_photo) }}"
                 width="300"
                 style="border-radius:10px; border:1px solid #ccc;">

        </div>

    @endif

    {{-- DATE --}}
    <div class="section">

        <div class="label">
            Created At
        </div>

        <div class="box">
            {{ $ticket->created_at }}
        </div>

    </div>

    {{-- SIGNATURE --}}
    <table class="signature">

        <tr>

            <td>
                Prepared By
            </td>

            <td>
                Approved By
            </td>

        </tr>

        <tr>

            <td class="sign-box">
                Helpdesk Staff
            </td>

            <td class="sign-box">
                Hotel Management
            </td>

        </tr>

    </table>

    {{-- FOOTER --}}
    <div class="footer">

        Generated by Helpdesk Hotel System • {{ date('Y') }}

    </div>

</body>

</html> 