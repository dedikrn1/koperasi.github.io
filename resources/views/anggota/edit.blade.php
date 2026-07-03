@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card shadow-sm">

            <div class="card-header bg-warning">
                <h5 class="mb-0">
                    Edit Anggota
                </h5>
            </div>

            <div class="card-body">

                <form action="{{ route('anggota.update', $anggota->id) }}"method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label">
                                Kode Anggota
                            </label>

                            <input type="text"
                                   name="kode_anggota"
                                   class="form-control"
                                   value="{{ old('kode_anggota', $anggota->kode_anggota) }}"
                                   readonly>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label">
                                Nama Anggota
                            </label>

                            <input type="text"
                                   name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $anggota->nama) }}"
                                   required>

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                NIK
                            </label>

                            <input type="text"
                                   name="nik"
                                   class="form-control"
                                   value="{{ old('nik', $anggota->nik) }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                No. Telepon
                            </label>

                            <input type="text"
                                   name="telepon"
                                   class="form-control"
                                   value="{{ old('telepon', $anggota->telepon) }}">

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea name="alamat"
                                  rows="3"
                                  class="form-control">{{ old('alamat', $anggota->alamat) }}</textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Tanggal Masuk
                            </label>

                            <input type="date"
                                   name="tanggal_masuk"
                                   class="form-control"
                                   value="{{ old('tanggal_masuk', $anggota->tanggal_masuk) }}">

                        </div>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <a href="{{ route('anggota.index') }}"
                           class="btn btn-secondary">

                            <i class="bi bi-arrow-left"></i>
                            Kembali

                        </a>

                        <button type="submit"
                                class="btn btn-warning">

                            <i class="bi bi-save"></i>
                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection