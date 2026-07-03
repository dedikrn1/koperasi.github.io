@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">
                        <i class="fas fa-edit text-info me-2"></i>Edit Angsuran
                    </h1>
                    <p class="text-muted mb-0">Perbarui data angsuran yang sudah ada</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('angsuran.index') }}" class="text-decoration-none">Angsuran</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-circle me-3 mt-1 flex-shrink-0"></i>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading mb-2">Validasi Gagal</h6>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-4">
                    <form action="{{ route('angsuran.update', $angsuran->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Kode Angsuran --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-barcode text-info me-2"></i>Kode Angsuran
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg bg-light border-0"
                                   value="{{ $angsuran->kode_angsuran }}"
                                   readonly
                                   style="cursor: not-allowed;">
                            <small class="text-muted d-block mt-2">Kode tidak dapat diubah</small>
                        </div>

                        {{-- Informasi Pinjaman --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-file-invoice-dollar text-info me-2"></i>Pinjaman
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg bg-light border-0"
                                   value="{{ $angsuran->pinjaman->nomor_pinjaman }} - {{ $angsuran->anggota->nama }}"
                                   readonly
                                   style="cursor: not-allowed;">
                            <input type="hidden"
                                   name="id_pinjaman"
                                   value="{{ $angsuran->id_pinjaman }}">
                            <small class="text-muted d-block mt-2">Pinjaman tidak dapat diubah</small>

                            {{-- Detail Pinjaman --}}
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Nama Anggota</small>
                                            <p class="fw-600 mb-0">{{ $angsuran->anggota->nama }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Jumlah Pinjaman</small>
                                            <p class="fw-600 mb-0">Rp {{ number_format($angsuran->pinjaman->jumlah_pinjaman, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tanggal Angsuran --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-calendar-alt text-info me-2"></i>Tanggal Angsuran <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       name="tanggal_angsuran"
                                       class="form-control form-control-lg border-2 border-light"
                                       value="{{ old('tanggal_angsuran', $angsuran->tanggal_angsuran) }}"
                                       required
                                       style="transition: all 0.3s ease;">
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-credit-card text-info me-2"></i>Metode Pembayaran <span class="text-danger">*</span>
                                </label>
                                <select name="metode_pembayaran"
                                        class="form-select form-select-lg border-2 border-light"
                                        required
                                        style="transition: all 0.3s ease;">
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="tunai" {{ old('metode_pembayaran', $angsuran->metode_pembayaran) == 'tunai' ? 'selected' : '' }}>💵 Tunai</option>
                                    <option value="transfer" {{ old('metode_pembayaran', $angsuran->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>🏦 Transfer</option>
                                    <option value="cek" {{ old('metode_pembayaran', $angsuran->metode_pembayaran) == 'cek' ? 'selected' : '' }}>📄 Cek</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Nominal Angsuran --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-money-bill-wave text-info me-2"></i>Nominal Angsuran (Rp) <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="nominal_display"
                                       class="form-control form-control-lg border-2 border-light"
                                       placeholder="0"
                                       value="{{ old('nominal_angsuran', $angsuran->nominal_angsuran) ? number_format(old('nominal_angsuran', $angsuran->nominal_angsuran), 0, ',', '.') : '' }}"
                                       required
                                       style="transition: all 0.3s ease;">
                                <input type="hidden"
                                       name="nominal_angsuran"
                                       id="nominal_value"
                                       value="{{ old('nominal_angsuran', $angsuran->nominal_angsuran) }}">
                            </div>

                            {{-- Bunga --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-percent text-info me-2"></i>Bunga (Rp)
                                </label>
                                <input type="text"
                                       id="bunga_display"
                                       class="form-control form-control-lg border-2 border-light"
                                       placeholder="0"
                                       value="{{ old('bunga', $angsuran->bunga) ? number_format(old('bunga', $angsuran->bunga), 0, ',', '.') : '' }}"
                                       style="transition: all 0.3s ease;">
                                <input type="hidden"
                                       name="bunga"
                                       id="bunga_value"
                                       value="{{ old('bunga', $angsuran->bunga) }}">
                            </div>
                        </div>

                        {{-- Denda --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-exclamation-triangle text-info me-2"></i>Denda (Rp)
                            </label>
                            <input type="text"
                                   id="denda_display"
                                   class="form-control form-control-lg border-2 border-light"
                                   placeholder="0"
                                   value="{{ old('denda', $angsuran->denda) ? number_format(old('denda', $angsuran->denda), 0, ',', '.') : '' }}"
                                   style="transition: all 0.3s ease;">
                            <input type="hidden"
                                   name="denda"
                                   id="denda_value"
                                   value="{{ old('denda', $angsuran->denda) }}">
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-sticky-note text-info me-2"></i>Keterangan
                            </label>
                            <textarea name="keterangan"
                                      class="form-control form-control-lg border-2 border-light"
                                      rows="3"
                                      placeholder="Masukkan keterangan tambahan (opsional)"
                                      style="transition: all 0.3s ease; resize: vertical;">{{ old('keterangan', $angsuran->keterangan) }}</textarea>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-3 mt-5">
                            <button type="submit" class="btn btn-info btn-lg flex-grow-1">
                                <i class="fas fa-sync-alt me-2"></i>Perbarui Angsuran
                            </button>
                            <a href="{{ route('angsuran.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info alert-dismissible fade show mt-4 border-0" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Kode dan pinjaman tidak dapat diubah. Pastikan data lainnya sudah benar sebelum memperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .form-control-lg,
    .form-select-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .form-label {
        margin-bottom: 0.5rem;
        letter-spacing: 0.3px;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format number input
    const formatNumberInput = (displayId, valueId) => {
        const displayInput = document.getElementById(displayId);
        const valueInput = document.getElementById(valueId);

        if (displayInput) {
            displayInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                let formatted = '';
                if (value) {
                    formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
                this.value = formatted;
                valueInput.value = value || '0';
            });

            // Format on page load
            if (displayInput.value) {
                let value = displayInput.value.replace(/\D/g, '');
                if (value) {
                    displayInput.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    valueInput.value = value;
                }
            }
        }
    };

    formatNumberInput('nominal_display', 'nominal_value');
    formatNumberInput('bunga_display', 'bunga_value');
    formatNumberInput('denda_display', 'denda_value');
});
</script>
@endpush
