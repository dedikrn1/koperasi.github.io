<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $table = 'angsurans';

    protected $fillable = [
        'kode_anggota',
        'id_pinjaman',
        'nomor_pinjaman',
        'kode_angsuran',
        'tanggal_angsuran',
        'nominal_angsuran',
        'bunga',
        'denda',
        'total_pembayaran',
        'saldo_pinjaman',
        'metode_pembayaran',
        'keterangan',
    ];

    protected $dates = ['tanggal_angsuran'];

    /**
     * Relasi ke model Pinjaman
     */
    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman', 'id');
    }

    /**
     * Relasi ke model Anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'kode_anggota', 'kode_anggota');
    }
}
