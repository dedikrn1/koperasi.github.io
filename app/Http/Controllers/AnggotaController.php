<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Anggota::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $anggotas = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('anggota.index', compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kodeAnggota = 'AGT' . str_pad(
            Anggota::count() + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        return view('anggota.create', compact('kodeAnggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_anggota' => 'required|unique:anggotas,kode_anggota',
            'nama'         => 'required|max:100',
            'nik'          => 'nullable|max:20',
            'alamat'       => 'nullable',
            'telepon'      => 'nullable|max:20',
            'tanggal_masuk'=> 'nullable|date',
        ]);

        Anggota::create([
            'kode_anggota'  => $request->kode_anggota,
            'nama'          => $request->nama,
            'nik'           => $request->nik,
            'alamat'        => $request->alamat,
            'telepon'       => $request->telepon,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggotum)
    {
        return view('anggota.show', 
            [
            'anggota' => $anggotum
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Anggota $anggotum)
    {
        return view('anggota.edit', 
            [
            'anggota' => $anggotum
            ]
        );
    }

    //public function edit(Anggota $anggota)
    //{
      //  return view('anggota.edit', compact('anggota'));
    //}

    /**
     * Update the specified resource in storage.
     */

    
    public function update(Request $request, Anggota $anggotum)
    {
        $request->validate([
            //'kode_anggota' => 'required|unique:anggotas,kode_anggota,' . $anggotum->id,
            'nama'         => 'required|max:100',
            'nik'          => 'nullable|max:20',
            'alamat'       => 'nullable',
            'telepon'      => 'nullable|max:20',
            'tanggal_masuk'=> 'nullable|date',
        ]);

        $anggotum->update([
            //'kode_anggota'  => $request->kode_anggota,
            'nama'          => $request->nama,
            'nik'           => $request->nik,
            'alamat'        => $request->alamat,
            'telepon'       => $request->telepon,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggotum)
    {
        $anggotum->delete();

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }

    /**
     * Search anggota for autocomplete
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $anggotas = Anggota::where('nama', 'like', "%{$query}%")
            ->orWhere('kode_anggota', 'like', "%{$query}%")
            ->orderBy('nama')
            ->limit(10)
            ->get(['kode_anggota', 'nama']);

        return response()->json($anggotas);
    }
}