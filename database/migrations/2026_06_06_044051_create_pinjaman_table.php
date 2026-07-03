<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pinjaman', function (Blueprint $table) {
             $table->id();

            // Relasi ke tabel anggota
            // $table->foreignId('kode_anggota')
            //       ->constrained('anggotas')
            //       ->cascadeOnDelete();

            $table->string('kode_anggota');

            // Nomor transaksi pinjaman
            $table->string('nomor_pinjaman')->unique();

            // Tanggal pinjaman
            $table->date('tanggal_pinjam');

            // Jumlah uang yang dipinjam
            $table->decimal('jumlah_pinjaman', 15, 2);

            // Lama cicilan bulan
            $table->integer('tenor');

            // Persentase bunga
            $table->decimal('bunga', 5, 2)
                  ->default(0);

            // Total yang harus dikembalikan
            $table->decimal('total_pinjaman', 15, 2);

            // Jumlah cicilan per bulan
            $table->decimal('angsuran_per_bulan', 15, 2);

            // Status pinjaman
            $table->enum('status', [
                'diajukan',
                'disetujui',
                'berjalan',
                'lunas',
                'ditolak'
            ])->default('diajukan');


            // Keterangan tambahan
            $table->text('keterangan')
                  ->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
