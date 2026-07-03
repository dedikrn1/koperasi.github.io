<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Anggota;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //menampilkan data simpanan dengan relasi anggota
        $query = Simpanan::with('anggota');

        // Filter berdasarkan nama anggota
        if ($request->filled('nama')) {
            $query->whereHas('anggota', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan kode anggota
        if ($request->filled('kode_anggota')) {
            $query->where('kode_anggota', 'like', '%' . $request->kode_anggota . '%');
        }

        // Filter berdasarkan kode simpanan/transaksi
        if ($request->filled('kode_simpanan')) {
            $query->where('kode_simpanan', 'like', '%' . $request->kode_simpanan . '%');
        }

        $simpanans = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('simpanan.index', compact('simpanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //menambahkan data anggota
        $anggotas = Anggota::all();

        $kode = 'TR-' . date('YmdHis');

        return view('simpanan.create', compact(
            'anggotas',
            'kode'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
        'kode_anggota' => 'required',
        'jenis_simpanan' => 'required',
        'tanggal' => 'required',
        'nominal' => 'required|numeric|min:0',
        'status' => 'required',
        ]);

        // Ambil transaksi terakhir anggota 
        $simpananTerakhir = Simpanan::where('kode_anggota', $request->kode_anggota) 
        ->orderBy('id', 'desc') 
        ->first();
        
        // Saldo awal 
        $saldoTerakhir = 0;

        // Jika ada transaksi sebelumnya 
        if ($simpananTerakhir) 
        { 
            $saldoTerakhir = $simpananTerakhir->saldo; 
        }

        // Hitung saldo baru 
        if ($request->status == 'masuk') 
        { 
            $saldoBaru = $saldoTerakhir + $request->nominal; 
        } 
        else 
        { 
            $saldoBaru = $saldoTerakhir - $request->nominal; 
        }

        $simpanan = Simpanan::create([
            'kode_anggota'   => $request->kode_anggota,
            'kode_simpanan'  => $request->kode_simpanan,
            'jenis_simpanan' => $request->jenis_simpanan,
            'tanggal'        => $request->tanggal,
            'nominal'        => $request->nominal,
            'saldo'          => $saldoBaru,
            'status'         => $request->status,
            'keterangan'     => $request->keterangan,
        ]);

        return redirect()
            ->route('simpanan.print', $simpanan->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Simpanan $simpanan)
    {
        //
         return view('simpanan.show', compact('simpanan'));
    }

    /**
     * Print receipt for the specified resource.
     */
    public function print(Simpanan $simpanan)
    {
        return view('simpanan.print', compact('simpanan'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Simpanan $simpanan)
    {
        //
        $anggotas = Anggota::all();

        return view('simpanan.edit', compact(
            'simpanan',
            'anggotas'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Simpanan $simpanan)
    {
        //
        $request->validate([
            'kode_anggota' => 'required',
            'jenis_simpanan' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required|numeric',
            'status' => 'required'
        ]);

        // Ambil saldo sebelum transaksi ini 
        $saldoSebelumnya = Simpanan::where('kode_anggota', $request->kode_anggota)->where('id', '!=', $simpanan->id) ->latest() ->value('saldo') ?? 0; 
        
        
        // Hitung saldo baru 
        if ($request->status == 'masuk') 
        { 
            $saldoBaru = $saldoSebelumnya + $request->nominal; 
        } 
        else 
        { 
            $saldoBaru = $saldoSebelumnya - $request->nominal; 
        }

        // $simpanan->update($request->all());

        // Update data 
        $simpanan->update([ 
            'kode_anggota' => $request->kode_anggota, 
            'kode_simpanan' => $request->kode_simpanan, 
            'jenis_simpanan' => $request->jenis_simpanan, 
            'tanggal' => $request->tanggal, 
            'nominal' => $request->nominal, 
            'saldo' => $saldoBaru, 
            'status' => $request->status, 
            'keterangan' => $request->keterangan, 
        ]);

        return redirect()
            ->route('simpanan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Simpanan $simpanan)
    {
        //
         $simpanan->delete();

        return redirect()
            ->route('simpanan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
