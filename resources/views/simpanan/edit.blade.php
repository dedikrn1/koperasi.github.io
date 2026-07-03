@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">
                        <i class="fas fa-edit text-info me-2"></i>Edit Simpanan
                    </h1>
                    <p class="text-muted mb-0">Perbarui data simpanan yang sudah ada</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('simpanan.index') }}" class="text-decoration-none">Simpanan</a></li>
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
                    <form action="{{ route('simpanan.update', $simpanan->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Kode Simpanan --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-barcode text-primary me-2"></i>Kode Simpanan
                            </label>
                            <input type="text"
                                   name="kode_simpanan"
                                   class="form-control form-control-lg bg-light border-0"
                                   value="{{ $simpanan->kode_simpanan }}"
                                   readonly
                                   style="cursor: not-allowed;">
                            <small class="text-muted d-block mt-2">Kode tidak dapat diubah</small>
                        </div>

                        {{-- Anggota --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-user text-primary me-2"></i>Anggota
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg bg-light border-0"
                                   value="{{ $simpanan->kode_anggota }} - {{ $simpanan->anggota->nama }}"
                                   readonly
                                   style="cursor: not-allowed;">
                            <input type="hidden"
                                   name="kode_anggota"
                                   value="{{ $simpanan->kode_anggota }}">
                            <small class="text-muted d-block mt-2">Anggota tidak dapat diubah</small>
                        </div>

                        <div class="row">
                            {{-- Jenis Simpanan --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-layer-group text-primary me-2"></i>Jenis Simpanan <span class="text-danger">*</span>
                                </label>
                                <select name="jenis_simpanan"
                                        class="form-select form-select-lg border-2 border-light"
                                        required
                                        style="transition: all 0.3s ease;">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="pokok" {{ old('jenis_simpanan', $simpanan->jenis_simpanan) == 'pokok' ? 'selected' : '' }}>
                                        💰 Simpanan Pokok
                                    </option>
                                    <option value="wajib" {{ old('jenis_simpanan', $simpanan->jenis_simpanan) == 'wajib' ? 'selected' : '' }}>
                                        📋 Simpanan Wajib
                                    </option>
                                    <option value="sukarela" {{ old('jenis_simpanan', $simpanan->jenis_simpanan) == 'sukarela' ? 'selected' : '' }}>
                                        ✨ Simpanan Sukarela
                                    </option>
                                </select>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>Tanggal <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       name="tanggal"
                                       class="form-control form-control-lg border-2 border-light"
                                       value="{{ old('tanggal', $simpanan->tanggal) }}"
                                       required
                                       style="transition: all 0.3s ease;">
                            </div>
                        </div>

                        <div class="row">
                            {{-- Nominal --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-money-bill-wave text-primary me-2"></i>Nominal (Rp) <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="nominal_display"
                                       class="form-control form-control-lg border-2 border-light"
                                       placeholder="0"
                                       value="{{ old('nominal', $simpanan->nominal) ? number_format(old('nominal', $simpanan->nominal), 0, ',', '.') : '' }}"
                                       required
                                       style="transition: all 0.3s ease;">
                                <input type="hidden"
                                       name="nominal"
                                       id="nominal_value"
                                       value="{{ old('nominal', $simpanan->nominal) }}">
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-check-circle text-primary me-2"></i>Status <span class="text-danger">*</span>
                                </label>
                                <select name="status"
                                        class="form-select form-select-lg border-2 border-light"
                                        required
                                        style="transition: all 0.3s ease;">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="masuk" {{ old('status', $simpanan->status) == 'masuk' ? 'selected' : '' }}>
                                        ➕ Masuk
                                    </option>
                                    <option value="keluar" {{ old('status', $simpanan->status) == 'keluar' ? 'selected' : '' }}>
                                        ➖ Keluar
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-sticky-note text-primary me-2"></i>Keterangan
                            </label>
                            <textarea name="keterangan"
                                      class="form-control form-control-lg border-2 border-light"
                                      rows="3"
                                      placeholder="Masukkan keterangan tambahan (opsional)"
                                      style="transition: all 0.3s ease; resize: vertical;">{{ old('keterangan', $simpanan->keterangan) }}</textarea>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-3 mt-5">
                            <button type="submit" class="btn btn-info btn-lg flex-grow-1">
                                <i class="fas fa-sync-alt me-2"></i>Perbarui Simpanan
                            </button>
                            <a href="{{ route('simpanan.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info alert-dismissible fade show mt-4 border-0" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Kode simpanan dan anggota tidak dapat diubah. Pastikan data lainnya sudah benar sebelum memperbarui.
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

    #anggota_list .list-group-item {
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        border: none;
        border-bottom: 1px solid #f0f0f0;
    }

    #anggota_list .list-group-item:hover {
        background-color: #f8f9fa;
        padding-left: 1.5rem;
    }

    #anggota_list .list-group-item:last-child {
        border-bottom: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nominalDisplay = document.getElementById('nominal_display');
    const nominalValue = document.getElementById('nominal_value');
    const form = document.querySelector('form');

    // Format nominal dengan tanda titik saat input
    nominalDisplay.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, ''); // Hapus semua karakter non-digit
        
        // Format dengan tanda titik
        let formatted = '';
        if (value) {
            formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        
        // Update display value
        this.value = formatted;
        
        // Update hidden input dengan nilai asli (tanpa titik)
        nominalValue.value = value || '0';
    });

    // Format nominal saat halaman load
    if (nominalDisplay.value) {
        let value = nominalDisplay.value.replace(/\D/g, '');
        if (value) {
            nominalDisplay.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            nominalValue.value = value;
        }
    }

    // Validasi saat submit
    if (form) {
        form.addEventListener('submit', function(e) {
            // Pastikan nilai nominal tersimpan dengan benar
            let value = nominalDisplay.value.replace(/\D/g, '');
            if (!value || value === '0') {
                e.preventDefault();
                alert('⚠️ Nominal harus lebih dari 0');
                nominalDisplay.focus();
                return false;
            }
            nominalValue.value = value;
        });
    }
});
</script>
@endpush
