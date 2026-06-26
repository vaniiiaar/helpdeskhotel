<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk Hotel</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Toastify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        /* Badge notif di navbar */
        .notif-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            font-size: 11px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            display: none; /* hidden by default */
        }
        .notif-wrapper {
            position: relative;
            display: inline-block;
        }
    </style>
</head>

<body class="bg-light">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">

            <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
               href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logopullman.png') }}"
                     alt="Logo"
                     style="height:45px; width:auto;">
                <span>Helpdesk Hotel</span>
            </a>

            <div class="d-flex align-items-center gap-3">

                <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                    Dashboard
                </a>

                {{-- Tombol Tickets dengan badge notif (hanya staff & admin) --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                    <div class="notif-wrapper">
                        <a href="{{ route('tickets.index') }}" class="btn btn-light btn-sm">
                            🎫 Tickets
                        </a>
                        <span class="notif-badge" id="notifBadge">0</span>
                    </div>
                @else
                    <a href="{{ route('tickets.index') }}" class="btn btn-light btn-sm">
                        Tickets
                    </a>
                @endif

                <div class="text-white small">
                    👤 <strong>{{ auth()->user()->name }}</strong>
                    <span class="badge bg-warning text-dark">{{ auth()->user()->role }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>

            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    <div class="container py-4">
        @yield('content')
    </div>

    {{-- AUDIO NOTIFIKASI --}}
    <audio id="notifSound">
        <source src="{{ asset('sounds/notif.mp3') }}" type="audio/mpeg">
    </audio>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Toastify JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- ============================================================
         NOTIFICATION SCRIPTS
    ============================================================ --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const sound = document.getElementById('notifSound');

            // ============================================================
            // FLASH NOTIFICATIONS (setelah action)
            // ============================================================

            @if(session('ticket_created'))
                sound.play();
                Toastify({
                    text: "🆕 Ticket baru berhasil dibuat",
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#2563eb",
                    stopOnFocus: true,
                }).showToast();
            @endif

            @if(session('ticket_process'))
                sound.play();
                Toastify({
                    text: "🛠️ Ticket sedang diproses",
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#f59e0b",
                    stopOnFocus: true,
                }).showToast();
            @endif

            @if(session('ticket_closed'))
                sound.play();
                Toastify({
                    text: "✅ Ticket berhasil diselesaikan",
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#16a34a",
                    stopOnFocus: true,
                }).showToast();
            @endif

            @if(session('success'))
                Toastify({
                    text: "✅ {{ session('success') }}",
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#16a34a",
                    stopOnFocus: true,
                }).showToast();
            @endif

            // ============================================================
            // POLLING TIKET BARU (hanya staff & admin)
            // ============================================================
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')

                let isFirstPoll = true;
                let unreadCount = 0;
                const badge = document.getElementById('notifBadge');

                function pollNewTickets() {
                    fetch('/api/new-tickets-count')
                        .then(res => res.json())
                        .then(data => {

                            // Skip pertama kali supaya tidak notif saat buka halaman
                            if (isFirstPoll) {
                                isFirstPoll = false;
                                return;
                            }

                            if (data.count > 0) {

                                // Bunyikan notifikasi
                                sound.play().catch(() => {
                                    // Browser block autoplay, tidak apa-apa
                                });

                                // Update badge di navbar
                                unreadCount += data.count;
                                badge.textContent = unreadCount;
                                badge.style.display = 'flex';

                                // Reset badge saat klik tickets
                                document.querySelectorAll('a[href*="tickets"]').forEach(el => {
                                    el.addEventListener('click', () => {
                                        unreadCount = 0;
                                        badge.style.display = 'none';
                                    });
                                });

                                // Tampilkan toast untuk setiap tiket baru
                                data.tickets.forEach(function (ticket) {

                                    let bgColor = '#dc2626'; // default merah
                                    if (ticket.priority === 'Medium') bgColor = '#f59e0b';
                                    if (ticket.priority === 'Low')    bgColor = '#2563eb';
                                    if (ticket.priority === 'Urgent') bgColor = '#7c3aed';

                                    Toastify({
                                        text: "🆕 Ticket Baru!\n[" + ticket.priority + "] " + ticket.title + "\n📍 Kamar " + ticket.room_number,
                                        duration: 8000,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: bgColor,
                                        stopOnFocus: true,
                                        style: {
                                            borderRadius: "10px",
                                            fontSize: "14px",
                                            lineHeight: "1.6",
                                        },
                                        onClick: function () {
                                            window.location.href = '/tickets';
                                        }
                                    }).showToast();
                                });
                            }
                        })
                        .catch(err => console.warn('Polling error:', err));
                }

                // Polling setiap 15 detik
                setInterval(pollNewTickets, 15000);

            @endif

        });
    </script>

    {{-- Slot untuk script tambahan dari halaman child --}}
    @stack('scripts')

</body>
</html>
