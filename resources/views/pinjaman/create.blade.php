@extends('layouts.app')

@section('content')

<div class="container">


<div class="card">


    <div class="card-header">

        <h3>Tambah Pinjaman</h3>

    </div>



    <div class="card-body">



        {{-- Error Validation --}}

        @if ($errors->any())


            <div class="alert alert-danger">


                <ul class="mb-0">


                    @foreach ($errors->all() as $error)


                        <li>
                            {{ $error }}
                        </li>


                    @endforeach


                </ul>


            </div>


        @endif





        <form action="{{ route('pinjaman.store') }}"

              method="POST">


            @csrf






            {{-- Nomor Pinjaman --}}


            <div class="mb-3">


                <label class="form-label">

                    Nomor Pinjaman

                </label>



                <input type="text"

                       name="nomor_pinjaman"

                       class="form-control"

                       value="{{ old('nomor_pinjaman',$kode ?? '') }}"

                       readonly>



            </div>







            {{-- Anggota --}}


            <div class="mb-3">


                <label class="form-label">

                    Anggota

                </label>



                <select name="kode_anggota"

                        class="form-control"

                        required>




                    <option value="">

                        -- Pilih Anggota --

                    </option>





                    @foreach($anggotas as $anggota)



                    <option value="{{ $anggota->kode_anggota }}"


                    {{ old('kode_anggota') == $anggota->kode_anggota ? 'selected':'' }}>



                        {{ $anggota->kode_anggota }} - {{ $anggota->nama }}



                    </option>




                    @endforeach




                </select>



            </div>







            {{-- Tanggal Pinjam --}}


            <div class="mb-3">


                <label class="form-label">

                    Tanggal Pinjam

                </label>



                <input type="date"

                       name="tanggal_pinjam"

                       class="form-control"


                       value="{{ old('tanggal_pinjam',date('Y-m-d')) }}"

                       required>



            </div>








            {{-- Jumlah Pinjaman --}}


            <div class="mb-3">


                <label class="form-label">

                    Jumlah Pinjaman

                </label>



                <input type="number"

                       name="jumlah_pinjaman"

                       class="form-control"


                       value="{{ old('jumlah_pinjaman') }}"

                       min="0"

                       required>



            </div>








            {{-- Tenor --}}


            <div class="mb-3">


                <label class="form-label">

                    Tenor

                </label>



                <input type="number"

                       name="tenor"

                       class="form-control"


                       value="{{ old('tenor') }}"

                       min="1"

                       placeholder="Contoh : 12"

                       required>



                <small class="text-muted">

                    Lama cicilan dalam bulan

                </small>


            </div>









            {{-- Bunga --}}


            <div class="mb-3">


                <label class="form-label">

                    Bunga (%)

                </label>



                <input type="number"

                       name="bunga"

                       class="form-control"


                       value="{{ old('bunga',0) }}"

                       step="0.01"

                       min="0"

                       required>



            </div>








            {{-- Status --}}


            <div class="mb-3">


                <label class="form-label">

                    Status

                </label>



                <select name="status"

                        class="form-control"

                        required>



                    <option value="diajukan"

                    {{ old('status')=='diajukan'?'selected':'' }}>

                        Diajukan

                    </option>




                    <option value="disetujui">

                        Disetujui

                    </option>




                    <option value="berjalan">

                        Berjalan

                    </option>




                    <option value="lunas">

                        Lunas

                    </option>




                    <option value="ditolak">

                        Ditolak

                    </option>



                </select>



            </div>








            {{-- Keterangan --}}


            <div class="mb-3">


                <label class="form-label">

                    Keterangan

                </label>



                <textarea name="keterangan"

                          class="form-control"

                          rows="3">{{ old('keterangan') }}</textarea>



            </div>







            {{-- Tombol --}}


            <div class="d-flex gap-2">



                <button type="submit"

                        class="btn btn-success">


                    Simpan


                </button>





                <a href="{{ route('pinjaman.index') }}"

                   class="btn btn-secondary">


                    Kembali


                </a>



            </div>






        </form>



    </div>



</div>


</div>


@endsection