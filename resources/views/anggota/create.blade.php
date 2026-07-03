@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card shadow-sm">

            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    Tambah Anggota
                </h5>
            </div>

            <div class="card-body">

                <form action="{{ route('anggota.store') }}"
                      method="POST">

                    @csrf

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label">
                                Kode Anggota
                            </label>

                            <input type="text"
                                   name="kode_anggota"
                                   class="form-control @error('kode_anggota') is-invalid @enderror"
                                   value="{{ old('kode_anggota', $kodeAnggota ?? '') }}"
                                   readonly>

                            @error('kode_anggota')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label">
                                Nama Anggota
                            </label>

                            <input type="text"
                                   name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}"
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
                                   value="{{ old('nik') }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                No. Telepon
                            </label>

                            <input type="text"
                                   name="telepon"
                                   class="form-control"
                                   value="{{ old('telepon') }}">

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea name="alamat"
                                  rows="3"
                                  class="form-control">{{ old('alamat') }}</textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Tanggal Masuk
                            </label>

                            <input type="date"
                                   name="tanggal_masuk"
                                   class="form-control"
                                   value="{{ old('tanggal_masuk', date('Y-m-d')) }}">

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
                                class="btn btn-primary">

                            <i class="bi bi-save"></i>
                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection