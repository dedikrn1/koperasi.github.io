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
        Schema::create('simpanans', function (Blueprint $table) {

            $table->id();

            $table->string('kode_anggota');

            $table->foreign('kode_anggota')
                ->references('kode_anggota')
                ->on('anggotas')
                ->onDelete('cascade');

            $table->string('kode_simpanan')->unique();

            $table->enum('jenis_simpanan', [
                'pokok',
                'wajib',
                'sukarela'
            ]);

            $table->date('tanggal');

            $table->decimal('nominal', 15, 2)->default(0);

            $table->decimal('saldo', 15, 2)->default(0);

            $table->enum('status', [
                'masuk',
                'keluar'
            ])->default('masuk');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanans');
    }
};
