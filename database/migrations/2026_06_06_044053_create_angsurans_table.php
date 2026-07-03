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
        Schema::create('angsurans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_anggota');
            $table->unsignedBigInteger('id_pinjaman');
            $table->string('nomor_pinjaman');
            $table->string('kode_angsuran')->unique();
            $table->date('tanggal_angsuran');
            $table->decimal('nominal_angsuran', 12, 2);
            $table->decimal('bunga', 12, 2)->default(0);
            $table->decimal('denda', 12, 2)->default(0);
            $table->decimal('total_pembayaran', 12, 2);
            $table->decimal('saldo_pinjaman', 12, 2);
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'cek'])->default('tunai');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('kode_anggota')
                ->references('kode_anggota')
                ->on('anggotas')
                ->onDelete('cascade');

            $table->foreign('id_pinjaman')
                ->references('id')
                ->on('pinjaman')
                ->onDelete('cascade');

            // Indexes
            $table->index('kode_anggota');
            $table->index('id_pinjaman');
            $table->index('tanggal_angsuran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsurans');
    }
};
