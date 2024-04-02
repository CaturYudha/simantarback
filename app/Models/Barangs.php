<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangs extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'ruangan_id',
        'user_id',
        'kode_barang',
        'nama_barang',
        'spesifikasi',
        'pengadaan',
        'jenis_barang',
        'kuantitas',
        'keterangan_barang',
        'keadaan_barang',
        'status_ketersediaan',
        'barcode',
    ];
    public $timestamps = false;
}
