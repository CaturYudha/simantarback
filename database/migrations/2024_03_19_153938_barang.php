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
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('merek_barang')->nullable();
            $table->date('tgl_pembelian')->nullable();
            $table->integer('harga_barang')->nullable();
            $table->enum('jenis_barang', ['barang sekolah', 'barang jurusan']);
            $table->integer('jumlah_barang')->nullable();
            $table->text('deskripsi_barang')->nullable();
            $table->enum('ketersediaan', ['tersedia', 'terpakai'])->nullable();
            $table->enum('kondisi_barang', ['baik', 'rusak'])->nullable();
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
