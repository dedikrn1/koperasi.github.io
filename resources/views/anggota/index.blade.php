@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 fw-bold">Data Anggota</h3>
            <p class="text-muted mb-0">Manajemen data anggota koperasi</p>
        </div>
        <a href="{{ route('anggota.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Anggota
        </a>
    </div>

    {{-- Data Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Cari nama atau kode anggota..." 
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
                    <thead class="table-light text-center">
                        <tr>
                            <th class="text-center" width="60">No</th>
                            <th>Kode Anggota</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Telepon</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center" width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggotas as $anggota)
                            <tr>
                                <td class="text-center">{{ ($anggotas->currentPage() - 1) * $anggotas->perPage() + $loop->iteration }}</td>
                                <td class="fw-medium">{{ $anggota->kode_anggota }}</td>
                                <td>{{ $anggota->nama }}</td>
                                <td>{{ $anggota->nik }}</td>
                                <td>{{ $anggota->telepon }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($anggota->tanggal_masuk)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('anggota.show', $anggota->id) }}" class="btn btn-info btn-sm text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Data anggota belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($anggotas->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="text-muted">
                        Menampilkan {{ $anggotas->firstItem() }} sampai {{ $anggotas->lastItem() }} dari {{ $anggotas->total() }} anggota
                    </div>
                    <div>
                        {{ $anggotas->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection