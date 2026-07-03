@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">
                        <i class="fas fa-eye text-info me-2"></i>Detail Angsuran
                    </h1>
                    <p class="text-muted mb-0">Informasi lengkap pembayaran angsuran</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('angsuran.index') }}" class="text-decoration-none">Angsuran</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            {{-- Kartu Info Utama --}}
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-cash-coin me-2"></i>Data Angsuran
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Kode Angsuran</label>
                                <p class="h6 fw-600">{{ $angsuran->kode_angsuran }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Tanggal Angsuran</label>
                                <p class="h6 fw-600">{{ \Carbon\Carbon::parse($angsuran->tanggal_angsuran)->format('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Metode Pembayaran</label>
                                <p class="h6 fw-600">
                                    @if($angsuran->metode_pembayaran == 'tunai')
                                        <span class="badge bg-warning">💵 Tunai</span>
                                    @elseif($angsuran->metode_pembayaran == 'transfer')
                                        <span class="badge bg-info">🏦 Transfer</span>
                                    @else
                                        <span class="badge bg-secondary">📄 Cek</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Keterangan</label>
                                <p class="h6 fw-600">{{ $angsuran->keterangan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Info Anggota dan Pinjaman --}}
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person me-2"></i>Informasi Anggota & Pinjaman
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Nama Anggota</label>
                                <p class="h6 fw-600 mb-0">{{ $angsuran->anggota->nama }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Kode Anggota</label>
                                <p class="h6 fw-600 mb-0">{{ $angsuran->kode_anggota }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Nomor Pinjaman</label>
                                <p class="h6 fw-600 mb-0">{{ $angsuran->nomor_pinjaman }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Status Pinjaman</label>
                                <p class="h6 fw-600 mb-0">
                                    @if($angsuran->pinjaman->status == 'aktif')
                                        <span class="badge bg-warning">⏳ Aktif</span>
                                    @elseif($angsuran->pinjaman->status == 'lunas')
                                        <span class="badge bg-success">✅ Lunas</span>
                                    @else
                                        <span class="badge bg-danger">❌ Ditolak</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Rincian Pembayaran --}}
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calculator me-2"></i>Rincian Pembayaran
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Nominal Angsuran</label>
                                <p class="h5 fw-700 text-success mb-0">Rp {{ number_format($angsuran->nominal_angsuran, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Bunga</label>
                                <p class="h5 fw-700 text-info mb-0">Rp {{ number_format($angsuran->bunga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Denda</label>
                                <p class="h5 fw-700 text-warning mb-0">Rp {{ number_format($angsuran->denda, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-success p-3 rounded mb-3 text-white">
                                <label class="form-label text-white-50 small">Total Pembayaran</label>
                                <p class="h5 fw-700 mb-0">Rp {{ number_format($angsuran->total_pembayaran, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info mb-0">
                        <strong>Saldo Pinjaman Setelah Pembayaran:</strong><br>
                        <h4 class="mt-2 mb-0 text-danger">Rp {{ number_format($angsuran->saldo_pinjaman, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            {{-- Kartu Info Pinjaman Awal --}}
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark me-2"></i>Informasi Pinjaman Awal
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Jumlah Pinjaman</label>
                                <p class="h6 fw-600 mb-0">Rp {{ number_format($angsuran->pinjaman->jumlah_pinjaman, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Tenor</label>
                                <p class="h6 fw-600 mb-0">{{ $angsuran->pinjaman->tenor }} Bulan</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Bunga</label>
                                <p class="h6 fw-600 mb-0">{{ $angsuran->pinjaman->bunga }}%</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-3">
                                <label class="form-label text-muted small">Angsuran Per Bulan</label>
                                <p class="h6 fw-600 mb-0">Rp {{ number_format($angsuran->pinjaman->angsuran_per_bulan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('angsuran.edit', $angsuran->id) }}" class="btn btn-warning btn-lg flex-grow-1">
                    <i class="bi bi-pencil me-2"></i> Edit Angsuran
                </a>
                <a href="{{ route('angsuran.index') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .bg-gradient {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-primary-rgb));
    }

    .h5, .h6 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .card-header {
        padding: 1.25rem;
        border-bottom: 0;
    }
</style>
@endpush

@endsection
