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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruangan_id')->constrained('ruangans')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('spesifikasi')->nullable();
            $table->date('pengadaan')->nullable();
            $table->enum('jenis_barang', ['barang sekolah', 'barang jurusan']);
            $table->integer('kuantitas')->nullable();
            $table->text('keterangan_barang')->nullable();
            $table->enum('keadaan_barang', ['baik', 'rusak ringan', 'rusak sedang', 'rusak berat'])->nullable();
            $table->enum('status_ketersediaan', ['tersedia', 'terpakai'])->nullable();
            $table->string('barcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
