<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjamans extends Model
{
    use HasFactory;
    protected $table = 'Peminjamans';

    protected $fillable = [	
        'user_id',
        'nama_peminjam',	
        'tgl_peminjaman',	
        'tgl_pengembalian',
        'keterangan',
        'jumlah',
        'status_peminjaman',
        'status_pengajuan'		
    ];

}
