@extends('layouts.app')

@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">✏️ Edit Ticket</h2>
            <span class="text-muted small">{{ $ticket->ticket_code }}</span>
        </div>
        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    {{-- CARD FORM --}}
    <div class="card shadow-sm border-0" style="border-radius: 16px; overflow: hidden;">

        <div class="card-header bg-dark text-white p-4">
            <h5 class="mb-0 fw-bold">Detail Ticket</h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('tickets.update', $ticket->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="editForm">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- NO KAMAR --}}
                    <div class="col-md-6">
                        <label class="fw-semibold mb-1">🏨 No Kamar</label>
                        <input type="text"
                               name="room_number"
                               class="form-control @error('room_number') is-invalid @enderror"
                               value="{{ old('room_number', $ticket->room_number) }}">
                        @error('room_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- KATEGORI --}}
                    <div class="col-md-6">
                        <label class="fw-semibold mb-1">📂 Kategori</label>
                        <select name="category"
                                class="form-select @error('category') is-invalid @enderror">
                            @foreach(['Housekeeping','Maintenance','Engineering','IT Support','Security','Front Office'] as $cat)
                                <option value="{{ $cat }}"
                                    {{ old('category', $ticket->category) == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PRIORITAS --}}
                    <div class="col-md-6">
                        <label class="fw-semibold mb-1">🚨 Prioritas</label>
                        <select name="priority"
                                class="form-select @error('priority') is-invalid @enderror">
                            @foreach(['Low','Medium','High','Urgent'] as $prio)
                                <option value="{{ $prio }}"
                                    {{ old('priority', $ticket->priority) == $prio ? 'selected' : '' }}>
                                    {{ $prio }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6">
                        <label class="fw-semibold mb-1">📊 Status</label>
                        <select name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                id="statusSelect">
                            @foreach(['Open','Process','Closed'] as $st)
                                <option value="{{ $st }}"
                                    {{ old('status', $ticket->status) == $st ? 'selected' : '' }}>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- JUDUL --}}
                    <div class="col-12">
                        <label class="fw-semibold mb-1">📝 Judul</label>
                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $ticket->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="col-12">
                        <label class="fw-semibold mb-1">💬 Deskripsi</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="4">{{ old('description', $ticket->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ASSIGNED TO --}}
                    <div class="col-md-6">
                        <label class="fw-semibold mb-1">👤 Assigned To</label>
                        <input type="text"
                               name="assigned_to"
                               class="form-control"
                               placeholder="Nama staff yang ditugaskan"
                               value="{{ old('assigned_to', $ticket->assigned_to) }}">
                    </div>

                    {{-- LAPORAN PENYELESAIAN --}}
                    <div class="col-12">
                        <label class="fw-semibold mb-1">📋 Laporan Penyelesaian</label>
                        <textarea name="report"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Isi jika ticket sudah diselesaikan...">{{ old('report', $ticket->report) }}</textarea>
                    </div>

                    {{-- FOTO --}}
                    <div class="col-12">
                        <label class="fw-semibold mb-1">📷 Foto Penyelesaian</label>
                        @if($ticket->report_photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $ticket->report_photo) }}"
                                     class="img-thumbnail"
                                     width="150">
                                <p class="small text-muted mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                            </div>
                        @endif
                        <input type="file"
                               name="photo"
                               class="form-control"
                               accept="image/*">
                    </div>

                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="button"
                            class="btn btn-primary px-4"
                            id="btnSubmit">
                        💾 Simpan Perubahan
                    </button>
                    <a href="{{ route('tickets.show', $ticket->id) }}"
                       class="btn btn-outline-secondary px-4">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

{{-- ============================================================
     MODAL KONFIRMASI CLOSE TICKET
============================================================ --}}
<div class="modal fade" id="modalCloseConfirm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden;">

            {{-- Header --}}
            <div class="modal-header bg-success text-white border-0 p-4">
                <h5 class="modal-title fw-bold">⚠️ Konfirmasi Close Ticket</h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body text-center py-5 px-4">
                <div style="font-size: 4rem;" class="mb-3">✅</div>
                <h5 class="fw-bold mb-2">Yakin ingin menutup ticket ini?</h5>
                <p class="text-muted mb-1">
                    Pastikan masalah sudah <strong>benar-benar terselesaikan</strong><br>
                    sebelum menutup ticket.
                </p>
                <div class="alert alert-warning border-0 rounded-3 mt-3 text-start">
                    <small>
                        ⚠️ Setelah ticket ditutup, status tidak dapat diubah kembali ke <strong>Open</strong> atau <strong>Process</strong>.
                    </small>
                </div>

                {{-- Info ticket yang akan ditutup --}}
                <div class="bg-light rounded-3 p-3 text-start">
                    <div class="small text-muted mb-1">Ticket yang akan ditutup:</div>
                    <strong>{{ $ticket->ticket_code }}</strong><br>
                    <span class="small text-muted">{{ $ticket->title }} — Kamar {{ $ticket->room_number }}</span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 pb-4 gap-2">
                <button type="button"
                        class="btn btn-outline-secondary flex-fill"
                        data-bs-dismiss="modal">
                    ← Batal
                </button>
                <button type="button"
                        class="btn btn-success flex-fill fw-bold"
                        id="btnConfirmClose">
                    ✅ Ya, Tutup Ticket
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const btnSubmit      = document.getElementById('btnSubmit');
        const btnConfirm     = document.getElementById('btnConfirmClose');
        const statusSelect   = document.getElementById('statusSelect');
        const editForm       = document.getElementById('editForm');
        const modalEl        = document.getElementById('modalCloseConfirm');
        const modal          = new bootstrap.Modal(modalEl);

        // Klik tombol Simpan
        btnSubmit.addEventListener('click', function () {

            const selectedStatus = statusSelect.value;

            if (selectedStatus === 'Closed') {
                // Tampilkan modal konfirmasi dulu
                modal.show();
            } else {
                // Langsung submit untuk status lain
                editForm.submit();
            }
        });

        // Klik "Ya, Tutup Ticket" di modal
        btnConfirm.addEventListener('click', function () {
            modal.hide();
            editForm.submit();
        });

    });
</script>
@endpush
