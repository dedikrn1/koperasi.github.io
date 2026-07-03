<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Angsuran::with(['pinjaman', 'anggota']);

        // Filter berdasarkan nama anggota
        if ($request->filled('nama')) {
            $query->whereHas('anggota', function ($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->nama.'%');
            });
        }

        // Filter berdasarkan kode anggota
        if ($request->filled('kode_anggota')) {
            $query->where('kode_anggota', 'like', '%'.$request->kode_anggota.'%');
        }

        // Filter berdasarkan nomor pinjaman
        if ($request->filled('nomor_pinjaman')) {
            $query->where('nomor_pinjaman', 'like', '%'.$request->nomor_pinjaman.'%');
        }

        $angsurans = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('angsuran.index', compact('angsurans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pinjamans = Pinjaman::where('status', 'aktif')->get();
        $kode = 'ANG-'.date('YmdHis');

        return view('angsuran.create', compact('pinjamans', 'kode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pinjaman' => 'required|exists:pinjaman,id',
            'tanggal_angsuran' => 'required|date',
            'nominal_angsuran' => 'required|numeric|min:1',
            'bunga' => 'nullable|numeric|min:0',
            'denda' => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer,cek',
        ]);

        // Ambil data pinjaman
        $pinjaman = Pinjaman::findOrFail($request->id_pinjaman);

        // Ambil saldo pinjaman terakhir dari angsuran sebelumnya
        $angsuranTerakhir = Angsuran::where('id_pinjaman', $request->id_pinjaman)
            ->orderBy('id', 'desc')
            ->first();

        $saldoSebelumnya = $angsuranTerakhir ? $angsuranTerakhir->saldo_pinjaman : $pinjaman->total_pinjaman;

        // Hitung total pembayaran
        $bunga = $request->bunga ?? 0;
        $denda = $request->denda ?? 0;
        $totalPembayaran = $request->nominal_angsuran + $bunga + $denda;

        // Hitung saldo pinjaman setelah pembayaran
        $saldoBaru = $saldoSebelumnya - $request->nominal_angsuran;
        $saldoBaru = max(0, $saldoBaru); // Tidak boleh minus

        // Buat angsuran
        $angsuran = Angsuran::create([
            'kode_anggota' => $pinjaman->kode_anggota,
            'id_pinjaman' => $request->id_pinjaman,
            'nomor_pinjaman' => $pinjaman->nomor_pinjaman,
            'kode_angsuran' => $request->kode_angsuran,
            'tanggal_angsuran' => $request->tanggal_angsuran,
            'nominal_angsuran' => $request->nominal_angsuran,
            'bunga' => $bunga,
            'denda' => $denda,
            'total_pembayaran' => $totalPembayaran,
            'saldo_pinjaman' => $saldoBaru,
            'metode_pembayaran' => $request->metode_pembayaran,
            'keterangan' => $request->keterangan,
        ]);

        // Update status pinjaman jika lunas
        if ($saldoBaru <= 0) {
            $pinjaman->update(['status' => 'lunas']);
        }

        return redirect()
            ->route('angsuran.index')
            ->with('success', 'Angsuran berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Angsuran $angsuran)
    {
        $angsuran->load(['pinjaman', 'anggota']);

        return view('angsuran.show', compact('angsuran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Angsuran $angsuran)
    {
        $pinjamans = Pinjaman::all();

        return view('angsuran.edit', compact('angsuran', 'pinjamans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Angsuran $angsuran)
    {
        $request->validate([
            'tanggal_angsuran' => 'required|date',
            'nominal_angsuran' => 'required|numeric|min:1',
            'bunga' => 'nullable|numeric|min:0',
            'denda' => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer,cek',
        ]);

        // Ambil saldo pinjaman sebelum perubahan
        $pinjaman = $angsuran->pinjaman;
        $angsuranSebelumnya = Angsuran::where('id_pinjaman', $angsuran->id_pinjaman)
            ->where('id', '!=', $angsuran->id)
            ->orderBy('id', 'desc')
            ->first();

        $saldoSebelumnya = $angsuranSebelumnya ? $angsuranSebelumnya->saldo_pinjaman : $pinjaman->total_pinjaman;

        // Hitung saldo baru
        $bunga = $request->bunga ?? 0;
        $denda = $request->denda ?? 0;
        $totalPembayaran = $request->nominal_angsuran + $bunga + $denda;
        $saldoBaru = $saldoSebelumnya - $request->nominal_angsuran;
        $saldoBaru = max(0, $saldoBaru);

        // Update angsuran
        $angsuran->update([
            'tanggal_angsuran' => $request->tanggal_angsuran,
            'nominal_angsuran' => $request->nominal_angsuran,
            'bunga' => $bunga,
            'denda' => $denda,
            'total_pembayaran' => $totalPembayaran,
            'saldo_pinjaman' => $saldoBaru,
            'metode_pembayaran' => $request->metode_pembayaran,
            'keterangan' => $request->keterangan,
        ]);

        // Update status pinjaman
        if ($saldoBaru <= 0) {
            $pinjaman->update(['status' => 'lunas']);
        } else {
            $pinjaman->update(['status' => 'aktif']);
        }

        return redirect()
            ->route('angsuran.index')
            ->with('success', 'Angsuran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Angsuran $angsuran)
    {
        $pinjaman = $angsuran->pinjaman;
        $angsuran->delete();

        // Reset status pinjaman menjadi aktif
        $pinjaman->update(['status' => 'aktif']);

        return redirect()
            ->route('angsuran.index')
            ->with('success', 'Angsuran berhasil dihapus');
    }
}
