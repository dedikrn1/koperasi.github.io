<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    public function index(Request $request)
    {
        $pinjamans = Pinjaman::with('anggota')
            ->when($request->search, function ($query) use ($request) {

                $query->where('nomor_pinjaman', 'like', '%'.$request->search.'%')
                    ->orWhere('kode_anggota', 'like', '%'.$request->search.'%');

            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10);

        return view('pinjaman.index', compact('pinjamans'));
    }

    public function create()
    {
        $anggotas = Anggota::orderBy('nama')->get();

        $kode = 'PJM-'.date('YmdHis');

        return view('pinjaman.create', compact('anggotas', 'kode'));

    }

    public function store(Request $request)
    {

        $request->validate([

            'kode_anggota' => 'required',
            'nomor_pinjaman' => 'required|unique:pinjaman',

            'tanggal_pinjam' => 'required',

            'jumlah_pinjaman' => 'required',
            'tenor' => 'required',

        ]);

        $total = $request->jumlah_pinjaman +
        ($request->jumlah_pinjaman *
        $request->bunga / 100);

        Pinjaman::create([

            'kode_anggota' => $request->kode_anggota,

            'nomor_pinjaman' => $request->nomor_pinjaman,

            'tanggal_pinjam' => $request->tanggal_pinjam,

            'jumlah_pinjaman' => $request->jumlah_pinjaman,

            'tenor' => $request->tenor,

            'bunga' => $request->bunga,

            'total_pinjaman' => $total,

            'angsuran_per_bulan' => $total / $request->tenor,

            'status' => 'diajukan',

            'keterangan' => $request->keterangan,

        ]);

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Data pinjaman berhasil disimpan');

    }

    public function edit(Pinjaman $pinjaman)
    {

        $anggotas = Anggota::orderBy('nama')->get();

        return view('pinjaman.edit',
            compact(
                'pinjaman',
                'anggotas'
            ));

    }

    public function update(Request $request,
        Pinjaman $pinjaman)
    {

        $request->validate([

            'kode_anggota' => 'required',
            'tanggal_pinjam' => 'required',
            'jumlah_pinjaman' => 'required',
            'tenor' => 'required',

        ]);

        $total = $request->jumlah_pinjaman +
        ($request->jumlah_pinjaman *
        $request->bunga / 100);

        $pinjaman->update([

            'kode_anggota' => $request->kode_anggota,

            'tanggal_pinjam' => $request->tanggal_pinjam,

            'jumlah_pinjaman' => $request->jumlah_pinjaman,

            'tenor' => $request->tenor,

            'bunga' => $request->bunga,

            'total_pinjaman' => $total,

            'angsuran_per_bulan' => $total / $request->tenor,

            'status' => $request->status,

            'keterangan' => $request->keterangan,

        ]);

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Data berhasil diubah');

    }

    public function destroy(Pinjaman $pinjaman)
    {

        $pinjaman->delete();

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Data berhasil dihapus');

    }

    /**
     * Search pinjaman for autocomplete
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $pinjamans = Pinjaman::with('anggota')
            ->where('status', 'aktif')
            ->where(function($q) use ($query) {
                $q->where('nomor_pinjaman', 'like', "%{$query}%")
                  ->orWhere('kode_anggota', 'like', "%{$query}%")
                  ->orWhereHas('anggota', function($sq) use ($query) {
                      $sq->where('nama', 'like', "%{$query}%");
                  });
            })
            ->with('anggota')
            ->orderBy('nomor_pinjaman')
            ->limit(10)
            ->get()
            ->map(function($pinjaman) {
                // Hitung saldo terakhir dari angsuran terbaru
                $angsuranTerakhir = $pinjaman->angsurans()->latest()->first();
                $saldoTerakhir = $angsuranTerakhir ? $angsuranTerakhir->saldo_pinjaman : $pinjaman->total_pinjaman;
                
                return [
                    'id' => $pinjaman->id,
                    'nomor_pinjaman' => $pinjaman->nomor_pinjaman,
                    'kode_anggota' => $pinjaman->kode_anggota,
                    'jumlah_pinjaman' => $pinjaman->jumlah_pinjaman,
                    'total_pinjaman' => $pinjaman->total_pinjaman,
                    'angsuran_per_bulan' => $pinjaman->angsuran_per_bulan,
                    'saldo_terakhir' => $saldoTerakhir,
                    'anggota' => $pinjaman->anggota,
                ];
            });

        return response()->json($pinjamans);
    }
}
