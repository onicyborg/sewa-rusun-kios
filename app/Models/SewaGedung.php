<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaGedung extends Model
{
    use HasFactory;

    protected $table = 'sewa_gedung';
    protected $fillable = [
        'nama_penyewa',
        'kontak_penyewa',
        'tanggal_sewa',
        'tanggal_akhir_sewa',
        'durasi_sewa',
        'keperluan',
        'status_pembayaran',
    ];
}
