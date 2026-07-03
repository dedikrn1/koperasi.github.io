<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $fillable = [
        'kode_anggota', 'nomor_pinjaman', 'tanggal_pinjam', 'jumlah_pinjaman',
        'tenor', 'bunga', 'total_pinjaman', 'angsuran_per_bulan', 'status', 'keterangan',
    ];

    /**
     * Relasi ke model Anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'kode_anggota', 'kode_anggota');
    }

    /**
     * Relasi ke model Angsuran
     */
    public function angsurans()
    {
        return $this->hasMany(Angsuran::class, 'id_pinjaman', 'id');
    }
}
