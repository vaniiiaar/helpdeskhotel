<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Masalah - Helpdesk Hotel</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            min-height: 100vh;
        }
        .card-form {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }
        .card-header-custom {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            padding: 2rem;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 0.65rem 1rem;
            transition: border-color 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        }
        .btn-submit {
            background: linear-gradient(135deg, #1e293b, #334155);
            border: none;
            border-radius: 12px;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: opacity 0.2s, transform 0.1s;
        }
        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        .priority-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .label-custom {
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-dark" style="background: rgba(0,0,0,0.3); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <img src="{{ asset('images/logopullman.png') }}"
                     alt="Logo"
                     style="height: 42px; width: auto;">
                <span style="font-size: 1.1rem;">Helpdesk Hotel</span>
            </a>
            <div class="text-white opacity-75 small">
                Pullman Jakarta Central Park
            </div>
        </div>
    </nav>

    {{-- FORM --}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">

                <div class="card card-form border-0">

                    {{-- HEADER --}}
                    <div class="card-header-custom text-white">
                        <div class="d-flex align-items-center gap-3">
                            <div style="font-size: 2.5rem;">🎫</div>
                            <div>
                                <h4 class="fw-bold mb-1">Lapor Masalah</h4>
                                <p class="mb-0 opacity-75 small">
                                    Tim kami siap membantu Anda 24 jam
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4 bg-white">

                        {{-- ERROR --}}
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-3">
                                <strong>⚠️ Harap perbaiki:</strong>
                                <ul class="mb-0 mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('guest.tickets.store') }}" method="POST">
                            @csrf

                            {{-- NAMA TAMU --}}
                            <div class="mb-3">
                                <label class="label-custom">👤 Nama Tamu</label>
                                <input type="text"
                                       name="guest_name"
                                       class="form-control @error('guest_name') is-invalid @enderror"
                                       placeholder="Nama lengkap Anda"
                                       value="{{ old('guest_name') }}">
                                @error('guest_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NO KAMAR --}}
                            <div class="mb-3">
                                <label class="label-custom">🏨 Nomor Kamar</label>
                                <input type="text"
                                       name="room_number"
                                       class="form-control @error('room_number') is-invalid @enderror"
                                       placeholder="Contoh: 205, 1012"
                                       value="{{ old('room_number') }}">
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- KATEGORI --}}
                            <div class="mb-3">
                                <label class="label-custom">📂 Kategori Masalah</label>
                                <select name="category"
                                        class="form-select @error('category') is-invalid @enderror">
                                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                    <option value="Housekeeping" {{ old('category') == 'Housekeeping' ? 'selected' : '' }}>🧹 Housekeeping</option>
                                    <option value="Maintenance"  {{ old('category') == 'Maintenance'  ? 'selected' : '' }}>🔧 Maintenance</option>
                                    <option value="Engineering"  {{ old('category') == 'Engineering'  ? 'selected' : '' }}>⚙️ Engineering</option>
                                    <option value="IT Support"   {{ old('category') == 'IT Support'   ? 'selected' : '' }}>💻 IT Support</option>
                                    <option value="Security"     {{ old('category') == 'Security'     ? 'selected' : '' }}>🔒 Security</option>
                                    <option value="Front Office" {{ old('category') == 'Front Office' ? 'selected' : '' }}>🏢 Front Office</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PRIORITAS --}}
                            <div class="mb-3">
                                <label class="label-custom">🚨 Tingkat Urgensi</label>
                                <select name="priority"
                                        class="form-select @error('priority') is-invalid @enderror">
                                    <option value="" disabled {{ old('priority') ? '' : 'selected' }}>-- Pilih Urgensi --</option>
                                    <option value="Low"    {{ old('priority') == 'Low'    ? 'selected' : '' }}>🟢 Low - Tidak mendesak</option>
                                    <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>🟡 Medium - Perlu segera</option>
                                    <option value="High"   {{ old('priority') == 'High'   ? 'selected' : '' }}>🔴 High - Mengganggu kenyamanan</option>
                                    <option value="Urgent" {{ old('priority') == 'Urgent' ? 'selected' : '' }}>🆘 Urgent - Darurat!</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JUDUL --}}
                            <div class="mb-3">
                                <label class="label-custom">📝 Judul Masalah</label>
                                <input type="text"
                                       name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Contoh: AC tidak dingin, Lampu mati, dll"
                                       value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="mb-4">
                                <label class="label-custom">💬 Deskripsi Masalah</label>
                                <textarea name="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Jelaskan masalah secara detail agar tim kami dapat membantu dengan cepat...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SUBMIT --}}
                            <button type="submit" class="btn btn-submit text-white w-100">
                                🚀 Kirim Laporan
                            </button>

                        </form>

                        {{-- INFO --}}
                        <div class="text-center mt-4 pt-3 border-top">
                            <small class="text-muted">
                                Staff kami akan menangani laporan Anda sesegera mungkin.<br>
                                Butuh bantuan darurat? Hubungi Front Desk di ext. <strong>0</strong>
                            </small>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
