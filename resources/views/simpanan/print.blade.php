@extends('layouts.app')

@section('content')
<style>
@media print{
  @page { size: 58mm auto; margin: 0; }
  /* hide everything except the receipt */
  body * { visibility: hidden; }
  .receipt, .receipt * { visibility: visible; }
  .receipt { position: absolute; left: 0; top: 0; box-sizing: border-box; }
  html,body{ margin:0; padding:0; color:#000; }
  body{ width:58mm; font-family: Arial, sans-serif; font-size:12px; }
  table{ width:100%; border-collapse:collapse; }
  th,td{ padding:4px 0; text-align:left; font-size:12px; }
  .text-center{ text-align:center; }
  .no-print{ display:none !important; }
}
@media screen{
  .receipt{ max-width:340px; margin:0 auto; }
}
</style>

<div class="container mt-4 receipt-wrapper">
    <div class="d-print-none mb-2">
        <button id="reprint" class="btn btn-primary btn-sm"><i class="bi bi-printer"></i> Cetak Ulang</button>
        <a href="{{ route('simpanan.index') }}" class="btn btn-secondary btn-sm ms-2">Kembali</a>
    </div>

    <div class="card p-4 receipt">
        <div class="text-center mb-3">
            <h5 class="mb-0">Tanda Terima Simpanan</h5>
            <small class="text-muted">Koperasi</small>
        </div>

        <table class="table table-borderless">
            <tr>
                <th>Kode Transaksi</th>
                <td>{{ $simpanan->kode_simpanan }}</td>
            </tr>
            <tr>
                <th>Anggota</th>
                <td>{{ $simpanan->anggota->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Petugas</th>
                <td>{{ auth()->user()->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ \Carbon\Carbon::parse($simpanan->tanggal)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Jenis</th>
                <td>{{ ucfirst($simpanan->jenis_simpanan) }}</td>
            </tr>
            <tr>
                <th>Nominal</th>
                <td>Rp {{ number_format($simpanan->nominal,0,',','.') }}</td>
            </tr>
            <tr>
                <th>Saldo</th>
                <td>Rp {{ number_format($simpanan->saldo,0,',','.') }}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>{{ $simpanan->keterangan }}</td>
            </tr>
        </table>

        <div class="text-end mt-4">
            <small class="text-muted">Dicetak: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i') }}</small>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        setTimeout(function(){ window.print(); }, 300);
    });

    document.addEventListener('DOMContentLoaded', function(){
        var btn = document.getElementById('reprint');
        if(btn){
            btn.addEventListener('click', function(){ window.print(); });
        }
    });
</script>
@endsection
