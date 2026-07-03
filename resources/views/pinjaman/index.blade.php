@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 fw-bold">Data Pinjaman</h3>
            <p class="text-muted mb-0">Manajemen data pinjaman koperasi</p>
        </div>
        <a href="{{ route('pinjaman.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pinjaman
        </a>
    </div>

    {{-- Data Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nomor pinjaman atau kode anggota..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No Pinjaman</th>
                            <th>Kode Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Tenor</th>
                            <th>Angsuran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pinjamans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nomor_pinjaman }}</td>
                            <td>{{ $item->kode_anggota }}</td>
                            <td>{{ $item->anggota->nama ?? '-' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item->tenor }} Bulan</td>
                            <td>Rp {{ number_format($item->angsuran_per_bulan, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td class="text-center">
                                <a href="{{ route('pinjaman.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('pinjaman.destroy', $item->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data pinjaman?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-3 px-3">
            {{ $pinjamans->links() }}
        </div>
    </div>
</div>
@endsection