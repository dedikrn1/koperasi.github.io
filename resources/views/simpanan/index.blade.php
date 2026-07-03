@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-2 fw-bold text-dark">
                <i class="bi bi-piggy-bank text-primary me-2"></i>Data Simpanan
            </h3>
            <p class="text-muted mb-0">Manajemen data simpanan anggota koperasi</p>
        </div>
        <a href="{{ route('simpanan.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Tambah Simpanan
        </a>
    </div>

    {{-- Data Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-600 text-muted">Nama Anggota</label>
                    <input 
                        type="text" 
                        name="nama" 
                        class="form-control" 
                        placeholder="Cari nama..." 
                        value="{{ request('nama') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-600 text-muted">Kode Anggota</label>
                    <input 
                        type="text" 
                        name="kode_anggota" 
                        class="form-control" 
                        placeholder="Cari kode anggota..." 
                        value="{{ request('kode_anggota') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-600 text-muted">Kode Transaksi</label>
                    <input 
                        type="text" 
                        name="kode_simpanan" 
                        class="form-control" 
                        placeholder="Cari kode transaksi..." 
                        value="{{ request('kode_simpanan') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('simpanan.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            {{-- Filter Status --}}
            @if(request()->filled('nama') || request()->filled('kode_anggota') || request()->filled('kode_simpanan'))
                <div class="alert alert-info alert-dismissible fade show m-3 mb-0 border-0" role="alert">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-funnel me-2"></i>
                            <strong>Filter Aktif:</strong>
                            @if(request()->filled('nama'))
                                <span class="badge bg-info me-2">Nama: {{ request('nama') }}</span>
                            @endif
                            @if(request()->filled('kode_anggota'))
                                <span class="badge bg-info me-2">Kode Anggota: {{ request('kode_anggota') }}</span>
                            @endif
                            @if(request()->filled('kode_simpanan'))
                                <span class="badge bg-info me-2">Kode Transaksi: {{ request('kode_simpanan') }}</span>
                            @endif
                        </div>
                        <span class="badge bg-success">{{ $simpanans->total() }} hasil</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
    <div class="table-responsive">
    <table class="table table-hover table-bordered align-middle mb-0">

        <thead class="table-light">
            <tr>
                <th style="width: 5%">No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Anggota</th>
                <th>Jenis</th>               
                <th class="text-end">Nominal</th>
                <th class="text-center">Status</th>
                <th class="text-center" style="width: 15%">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($simpanans as $item)

            <tr>
                <td>{{ $simpanans->firstItem() + $loop->index }}</td>
                <td>
                    <span class="badge bg-light text-dark fw-600">{{ $item->kode_simpanan }}</span>
                </td>
                <td class="text-center">
                    <small>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</small>
                </td>
                <td>
                    <div>
                        <strong>{{ $item->anggota->nama }}</strong><br>
                        <small class="text-muted">{{ $item->kode_anggota }}</small>
                    </div>
                </td>
                <td>
                    @if($item->jenis_simpanan == 'pokok')
                        <span class="badge bg-primary">💰 Pokok</span>
                    @elseif($item->jenis_simpanan == 'wajib')
                        <span class="badge bg-warning text-dark">📋 Wajib</span>
                    @else
                        <span class="badge bg-success">✨ Sukarela</span>
                    @endif
                </td>             
                <td class="text-end fw-600">
                    Rp {{ number_format($item->nominal,0,',','.') }}
                </td>
                <td class="text-center">
                    @if($item->status == 'masuk')
                        <span class="badge bg-success">➕ Masuk</span>
                    @else
                        <span class="badge bg-danger">➖ Keluar</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" data-print-url="{{ route('simpanan.print', $item->id) }}" class="btn btn-outline-info btn-print-receipt" title="Cetak">
                            <i class="bi bi-printer"></i>
                        </button>

                        <a href="{{ route('simpanan.edit',$item->id) }}"
                           class="btn btn-outline-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h6 class="modal-title">Konfirmasi Penghapusan</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-0">Apakah Anda yakin ingin menghapus transaksi <strong>{{ $item->kode_simpanan }}</strong>?</p>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('simpanan.destroy',$item->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>

            </tr>

            @empty
            <tr>
                <td colspan="8" class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">Tidak ada data simpanan yang ditemukan</p>
                </td>
            </tr>
            @endforelse

        </tbody>

    </table>
 </div>
</div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $simpanans->links() }}
    </div>
    </div>
</div>
<iframe id="print-iframe" style="display:none; width:0; height:0; border:0;"></iframe>

@push('scripts')
<style>
    .btn-group-sm .btn {
        padding: 0.35rem 0.5rem;
        font-size: 0.85rem;
    }

    .badge {
        font-weight: 500;
        padding: 0.4rem 0.6rem;
    }

    .table td {
        vertical-align: middle;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
    }

    .form-label {
        font-size: 0.85rem;
    }

    .btn-outline-info:hover {
        background-color: #17a2b8;
        color: white;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: black;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-print-receipt');
        const iframe = document.getElementById('print-iframe');

        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                const url = button.dataset.printUrl;
                if (!url) return;

                iframe.src = url;
                iframe.onload = function() {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                };
            });
        });
    });
</script>
@endpush
@endsection