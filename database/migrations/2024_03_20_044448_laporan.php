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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id(); // Primary key untuk tabel laporan
            $table->string('nama_laporan');
            $table->date('tgl_laporan');
            $table->text('keterangan')->nullable();
            $table->enum('jenis_laporan', ['laporan harian', 'laporan mingguan', 'laporan bulanan', 'laporan tahunan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
