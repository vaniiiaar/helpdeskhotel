# resources/views/auth/login.blade.php

```blade
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - Helpdesk Hotel</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        body {

            font-family: 'Poppins', sans-serif;

           
            background:
            linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
            url('{{ asset('images/hotelbg.jpg') }}');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

        }

        .login-card {

            width: 100%;
            max-width: 450px;

            border: none;
            border-radius: 20px;

            background: rgba(255,255,255,0.95);

            backdrop-filter: blur(10px);

            box-shadow: 0 10px 30px rgba(0,0,0,0.25);

            overflow: hidden;

        }

        .login-header {

            background: #212529;
            color: white;

            padding: 35px 20px;

            text-align: center;

        }

        .hotel-logo {

            width: 180px;
            height: auto;

            object-fit: contain;

            margin-bottom: 20px;

        }

        .welcome-title {

            font-size: 28px;
            font-weight: 700;

            margin-bottom: 5px;

        }

        .welcome-subtitle {

            font-size: 14px;
            opacity: 0.8;

        }

        .login-body {

            padding: 35px;

        }

        .form-control {

            height: 50px;
            border-radius: 12px;

        }

        .btn-login {

            height: 50px;

            border-radius: 12px;

            font-weight: 600;

            background: #212529;
            border: none;

            transition: 0.3s;

        }

        .btn-login:hover {

            background: #000;

            transform: translateY(-2px);

        }

        .footer-text {

            text-align: center;
            margin-top: 20px;

            color: #777;
            font-size: 13px;

        }

    </style>

</head>

<body>

    <div class="login-card">

        <div class="login-header">

            <img src="{{ asset('images/logopullman.png') }}"
                 class="hotel-logo"
                 alt="Hotel Logo">

            <div class="welcome-title">
                Welcome Helpdesk
            </div>

            <div class="welcome-subtitle">
                Internal Hotel Support System
            </div>

        </div>

        {{-- BODY --}}
        <div class="login-body">

            {{-- ERROR --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    {{ $errors->first() }}

                </div>

            @endif

            <form method="POST"
                  action="{{ route('login') }}">

                @csrf

                {{-- EMAIL --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Masukkan email"
                           required>

                </div>

                {{-- PASSWORD --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Masukkan password"
                           required>

                </div>

                {{-- BUTTON LOGIN --}}
                <button type="submit"
                        class="btn btn-dark btn-login w-100">

                    Login

                </button>

            </form>

            {{-- FOOTER --}}
            <div class="footer-text">

                Helpdesk Hotel © {{ date('Y') }}

            </div>

        </div>

    </div>

</body>
</html>
