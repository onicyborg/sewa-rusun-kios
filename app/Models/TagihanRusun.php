<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanRusun extends Model
{
    use HasFactory;

    protected $table = 'tagihan_rusun';
    protected $fillable = [
        'bulan',
        'tahun',
        'sewa',
        'denda',
        'air',
        'status_post',
        'status_pembayaran',
        'sewa_rusun_id',
    ];

    public function sewa_rusun()
    {
        return $this->belongsTo(SewaRusun::class, 'sewa_rusun_id');
    }
}
