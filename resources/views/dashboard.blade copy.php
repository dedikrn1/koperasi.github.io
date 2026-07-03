@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Koperasi</h1>
    </div>


    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Anggota</h5>
                    <p class="card-text display-6">{{ $totalAnggota }} Orang</p> </div>
            </div>
        </div>
        <div class="col-md-4"> 
           <div class="card text-white bg-success mb-3 shadow"> 
                <div class="card-body"> 
                    <h5 class="card-title">Total Simpanan</h5> 
                    <p class="card-text display-6"> Rp {{ number_format($totalSimpanan, 0, ',', '.') }} </p> 
                </div> 
            </div> 
     </div> 
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Pinjaman Aktif</h5>
                    <p class="card-text display-6">0</p>
                </div>
            </div>
        </div>
    </div>




    <div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header">Grafik Perkembangan Simpanan</div>
            <div class="card-body">
                <canvas id="simpananChart" height="100"></canvas>
            </div>
        </div>
    </div>


</div>

<script>
    const labels = [];
    const dataSimpanan = [];

        


    @foreach($grafikSimpanan as $item)
        labels.push("Bulan {{ $item->bulan }}");
        dataSimpanan.push({{ $item->total }});
    @endforeach

    const ctx = document.getElementById('simpananChart').getContext('2d');

    const simpananChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Simpanan (Rp)',
                data: dataSimpanan,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>



</div>
@endsection