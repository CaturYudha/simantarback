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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_peminjam');
            $table->date('tgl_peminjaman');
            $table->date('tgl_pengembalian');
            $table->text('keterangan')->nullable();
            $table->enum('status_peminjaman', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->enum('status_pengajuan', ['disetujui', 'tidak disetujui'])->default('disetujui');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
