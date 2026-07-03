@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Detail Anggota</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted">Kode Anggota</label>
                        <div class="form-control-plaintext border-bottom">
                            {{ $anggota->kode_anggota }}
                        </div>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label text-muted">Nama Anggota</label>
                        <div class="form-control-plaintext border-bottom">
                            {{ $anggota->nama }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">NIK</label>
                        <div class="form-control-plaintext border-bottom">
                            {{ $anggota->nik ?? '-' }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">No. Telepon</label>
                        <div class="form-control-plaintext border-bottom">
                            {{ $anggota->telepon ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Alamat</label>
                    <div class="form-control-plaintext border-bottom">
                        {{ $anggota->alamat ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted">Tanggal Masuk</label>
                        <div class="form-control-plaintext border-bottom">
                            {{ \Carbon\Carbon::parse($anggota->tanggal_masuk)->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection