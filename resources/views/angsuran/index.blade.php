@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-2 fw-bold text-dark">
                <i class="bi bi-cash-coin text-success me-2"></i>Data Angsuran
            </h3>
            <p class="text-muted mb-0">Manajemen pembayaran angsuran pinjaman anggota koperasi</p>
        </div>
        <a href="{{ route('angsuran.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Tambah Angsuran
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
                    <label class="form-label small fw-600 text-muted">Nomor Pinjaman</label>
                    <input 
                        type="text" 
                        name="nomor_pinjaman" 
                        class="form-control" 
                        placeholder="Cari nomor pinjaman..." 
                        value="{{ request('nomor_pinjaman') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('angsuran.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            {{-- Filter Status --}}
            @if(request()->filled('nama') || request()->filled('kode_anggota') || request()->filled('nomor_pinjaman'))
                <div class="alert alert-info alert-dismissible fade show m-3 mb-0 border-0" role="alert">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-funnel me-2"></i>
                            <strong>Filter Aktif:</strong>
                            @if(request()->filled('nama'))
                                <span class="badge bg-info me-2">Nama: {{ request('nama') }}</span>
                            @endif
                            @if(request()->filled('kode_anggota'))
                                <span class="badge bg-info me-2">Kode: {{ request('kode_anggota') }}</span>
                            @endif
                            @if(request()->filled('nomor_pinjaman'))
                                <span class="badge bg-info me-2">Pinjaman: {{ request('nomor_pinjaman') }}</span>
                            @endif
                        </div>
                        <span class="badge bg-success">{{ $angsurans->total() }} hasil</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Anggota</th>
                            <th>Nomor Pinjaman</th>
                            <th>Tanggal Angsuran</th>
                            <th class="text-end">Nominal Angsuran</th>
                            <th class="text-end">Bunga</th>
                            <th class="text-end">Total Pembayaran</th>
                            <th class="text-end">Saldo Pinjaman</th>
                            <th class="text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($angsurans as $item)
                        <tr>
                            <td>{{ $angsurans->firstItem() + $loop->index }}</td>
                            <td>
                                <div>
                                    <strong>{{ $item->anggota->nama }}</strong><br>
                                    <small class="text-muted">{{ $item->kode_anggota }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark fw-600">{{ $item->nomor_pinjaman }}</span>
                            </td>
                            <td class="text-center">
                                <small>{{ \Carbon\Carbon::parse($item->tanggal_angsuran)->format('d-m-Y') }}</small>
                            </td>
                            <td class="text-end fw-600">
                                Rp {{ number_format($item->nominal_angsuran, 0, ',', '.') }}
                            </td>
                            <td class="text-end">
                                Rp {{ number_format($item->bunga, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-600 text-success">
                                Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-600">
                                Rp {{ number_format($item->saldo_pinjaman, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('angsuran.show', $item->id) }}"
                                       class="btn btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('angsuran.edit', $item->id) }}"
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
                                                <p class="mb-0">Apakah Anda yakin ingin menghapus angsuran tanggal <strong>{{ \Carbon\Carbon::parse($item->tanggal_angsuran)->format('d-m-Y') }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('angsuran.destroy', $item->id) }}" method="POST" style="display:inline">
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
                            <td colspan="9" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">Tidak ada data angsuran yang ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4 pb-4">
            {{ $angsurans->links() }}
        </div>
    </div>
</div>

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
</style>
@endpush

@endsection
