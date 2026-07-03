@extends('layouts.app')

@section('content')

<div class="container">


<div class="card">


    <div class="card-header">

        <h3>Edit Pinjaman</h3>

    </div>



    <div class="card-body">



        <form action="{{ route('pinjaman.update', $pinjaman->id) }}"
              method="POST">


            @csrf
            @method('PUT')



            {{-- Nomor Pinjaman --}}

            <div class="mb-3">


                <label class="form-label">

                    Nomor Pinjaman

                </label>



                <input type="text"

                       name="nomor_pinjaman"

                       class="form-control"

                       value="{{ old('nomor_pinjaman', $pinjaman->nomor_pinjaman) }}"

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


                    {{ old('kode_anggota', $pinjaman->kode_anggota) == $anggota->kode_anggota ? 'selected':'' }}>



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


                       value="{{ old('tanggal_pinjam',$pinjaman->tanggal_pinjam) }}"

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


                       value="{{ old('jumlah_pinjaman',$pinjaman->jumlah_pinjaman) }}"

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


                       value="{{ old('tenor',$pinjaman->tenor) }}"

                       min="1"

                       required>



                <small class="text-muted">

                    Dalam bulan

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


                       value="{{ old('bunga',$pinjaman->bunga) }}"

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

                    {{ old('status',$pinjaman->status)=='diajukan'?'selected':'' }}>

                        Diajukan

                    </option>




                    <option value="disetujui"

                    {{ old('status',$pinjaman->status)=='disetujui'?'selected':'' }}>

                        Disetujui

                    </option>




                    <option value="berjalan"

                    {{ old('status',$pinjaman->status)=='berjalan'?'selected':'' }}>

                        Berjalan

                    </option>




                    <option value="lunas"

                    {{ old('status',$pinjaman->status)=='lunas'?'selected':'' }}>

                        Lunas

                    </option>




                    <option value="ditolak"

                    {{ old('status',$pinjaman->status)=='ditolak'?'selected':'' }}>

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

                          rows="3">{{ old('keterangan',$pinjaman->keterangan) }}</textarea>



            </div>







            {{-- Tombol --}}


            <div class="d-flex gap-2">


                <button type="submit"

                        class="btn btn-primary">


                    Update


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