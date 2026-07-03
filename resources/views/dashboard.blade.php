@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Dashboard Koperasi</h2>
            <p class="text-muted">
                Ringkasan aktivitas koperasi terbaru
            </p>
        </div>
    </div>


    {{-- Statistik --}}
    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>
                            <h6 class="text-muted">
                                Total Anggota
                            </h6>

                            <h2 class="fw-bold">
                                {{ $totalAnggota }}
                            </h2>

                            <small>
                                Orang Terdaftar
                            </small>
                        </div>

                        <div class="fs-1 text-primary">
                            <i class="bi bi-people"></i>
                        </div>

                    </div>

                </div>
            </div>
        </div>



        <div class="col-md-4 mb-3">

            <div class="card shadow border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">
                                Total Simpanan
                            </h6>

                            <h2 class="fw-bold">
                                Rp {{ number_format($totalSimpanan,0,',','.') }}
                            </h2>

                            <small>
                                Dana Masuk
                            </small>

                        </div>


                        <div class="fs-1 text-success">

                            <i class="bi bi-wallet2"></i>

                        </div>


                    </div>

                </div>

            </div>

        </div>




        <div class="col-md-4 mb-3">

            <div class="card shadow border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">


                        <div>

                            <h6 class="text-muted">
                                Pinjaman Aktif
                            </h6>


                            <h2 class="fw-bold">
                                {{ $totalPinjaman ?? 0 }}
                            </h2>


                            <small>
                                Transaksi Berjalan
                            </small>


                        </div>


                        <div class="fs-1 text-warning">

                            <i class="bi bi-cash-stack"></i>

                        </div>


                    </div>


                </div>


            </div>


        </div>


    </div>





    <div class="row mt-4">


        {{-- Grafik --}}
        <div class="col-md-8">


            <div class="card shadow border-0">


                <div class="card-header bg-white fw-bold">

                    Grafik Perkembangan Simpanan

                </div>


                <div class="card-body">


                    <canvas id="simpananChart"
                    height="120"></canvas>


                </div>


            </div>


        </div>





        {{-- Ranking Anggota --}}
        <div class="col-md-4">


            <div class="card shadow border-0">


                <div class="card-header bg-white fw-bold">

                    Top Transaksi Anggota

                </div>



                <div class="card-body">


                    <table class="table table-sm">


                        <thead>

                            <tr>

                                <th>
                                    Nama
                                </th>

                                <th>
                                    Total
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                        @foreach($anggotaTeraktif as $item)


                            <tr>


                                <td>

                                    {{ $item->nama }}

                                </td>


                                <td>

                                    Rp 
                                    {{ number_format($item->total_transaksi,0,',','.') }}

                                </td>


                            </tr>


                        @endforeach


                        </tbody>


                    </table>


                </div>


            </div>


        </div>


    </div>




</div>



{{-- Chart JS --}}

<script>


const labels = [];

const dataSimpanan = [];



@foreach($grafikSimpanan as $item)


labels.push(
    "Bulan {{ $item->bulan }}"
);


dataSimpanan.push(
    {{ $item->total }}
);



@endforeach





new Chart(

document
.getElementById('simpananChart'),


{

type:'line',


data:{


labels:labels,


datasets:[{

label:'Total Simpanan',


data:dataSimpanan,


borderWidth:3,


fill:true



}]


},



options:{


responsive:true,


plugins:{


legend:{


display:true


}


},


scales:{


y:{


beginAtZero:true


}


}



}


}

);




</script>


@endsection