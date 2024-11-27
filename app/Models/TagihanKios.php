<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanKios extends Model
{
    use HasFactory;

    protected $table = 'tagihan_kios';
    protected $fillable = [
        'bulan',
        'tahun',
        'sewa',
        'status_post',
        'status_pembayaran',
        'sewa_kios_id',
    ];

    public function sewa_kios()
    {
        return $this->belongsTo(SewaKios::class, 'sewa_kios_id');
    }
}
