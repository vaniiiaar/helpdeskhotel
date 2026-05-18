<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Helpdesk Hotel</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
            href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logopullman.png') }}"
                alt="Logo"
                style="height:40px; width:auto;">
                <span>
                    Helpdesk Hotel
                </span>
            </a>

            <div class="d-flex align-items-center gap-3">

                {{-- DASHBOARD --}}
                <a href="{{ route('dashboard') }}"
                   class="btn btn-light btn-sm">

                    Dashboard

                </a>

                {{-- TICKETS --}}
                <a href="{{ route('tickets.index') }}"
                   class="btn btn-light btn-sm">

                    Tickets

                </a>

                {{-- USER LOGIN INFO --}}
                <div class="text-white small">

                    👤
                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span class="badge bg-warning text-dark">

                        {{ auth()->user()->role }}

                    </span>

                </div>

                {{-- LOGOUT --}}
                <form action="{{ route('logout') }}"
                      method="POST">

                    @csrf

                    <button type="submit"
                            class="btn btn-danger btn-sm">

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </nav>

    {{-- CONTENT --}}
    <div class="container py-4">

        @yield('content')

    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>