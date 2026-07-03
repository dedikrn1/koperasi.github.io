<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnggota = Anggota::count();

        $totalSimpanan = Simpanan::where('status', 'masuk')
            ->sum('nominal');

        // $totalSimpanan = Simpanan::latest()->value('saldo') ?? 0;

        // $totalPinjaman = Pinjaman::where('status', 'disetujui')
        //     ->sum('nominal');

        // Data grafik simpanan per bulan (tahun berjalan)
        $grafikSimpanan = Simpanan::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('SUM(nominal) as total')
        )
            ->where('status', 'masuk')
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy('bulan')
            ->get();

        $bulanIndo = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $grafikSimpanan = $grafikSimpanan->map(function ($item) use ($bulanIndo) {
            $item->bulan = $bulanIndo[$item->bulan];

            return $item;
        });

        $anggotaTeraktif = Anggota::select(
            'anggotas.nama',
            DB::raw('SUM(simpanans.nominal) as total_transaksi')
        )
            ->join('simpanans', 'anggotas.kode_anggota', '=', 'simpanans.kode_anggota')
            ->groupBy('anggotas.nama')
            ->orderByDesc('total_transaksi')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalAnggota',
            'totalSimpanan',
            'grafikSimpanan',
            'anggotaTeraktif'
        ));

        // return view('dashboard', compact(
        //     'totalAnggota',
        //     'totalSimpanan',
        //     'grafikSimpanan'
        // ));
    }
}
