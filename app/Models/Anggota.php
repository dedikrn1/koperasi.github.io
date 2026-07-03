<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = [
        'kode_anggota',
        'nama',
        'nik',
        'alamat',
        'telepon',
        'tanggal_masuk'
    ];

    public function simpanans()
    {
        return $this->hasMany(Simpanan::class);
    }

    public function pinjaman()
    {

        return $this->hasMany(

            Pinjaman::class,

            'kode_anggota',

            'kode_anggota'

        );

    }
}
