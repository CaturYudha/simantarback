<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangs extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'merek_barang',
        'tgl_pembelian',
        'harga_barang',
        'jenis_barang',
        'jumlah_barang',
        'deskripsi_barang',
        'ketersediaan',
        'kondisi_barang',
        'barcode',
    ];
    public $timestamps = false;
}
