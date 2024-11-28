<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected $table = 'keluhan';

    protected $fillable = [
        'deskripsi',
        'status',
        'mekanik_id',
        'sewa_rusun_id',
    ];

    /**
     * Relasi ke tabel mekanikal.
     */
    public function mekanik()
    {
        return $this->belongsTo(Mekanikal::class, 'mekanik_id');
    }

    /**
     * Relasi ke tabel sewa_rusun.
     */
    public function sewaRusun()
    {
        return $this->belongsTo(SewaRusun::class, 'sewa_rusun_id');
    }
}
