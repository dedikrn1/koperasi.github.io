<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $fillable = [
        'kode_anggota',
        'kode_simpanan',
        'jenis_simpanan',
        'tanggal',
        'nominal',
        'saldo',
        'status',
        'keterangan',
    ];

    public function anggota()
    {
        return $this->belongsTo(
            Anggota::class,
            'kode_anggota', // foreign key di tabel simpanans
            'kode_anggota' // primary/unique key di tabel anggotas
        );
    }

    public function simpanans()
    {
        return $this->hasMany(Simpanan::class);

    }
}
