<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaRusun extends Model
{
    use HasFactory;

    protected $table = 'sewa_rusun';
    protected $fillable = [
        'tanggal_mulai_kontrak',
        'tanggal_selesai_kontrak',
        'user_id',
        'rusun_id'
    ];

    public function penyewa()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rusun()
    {
        return $this->belongsTo(Rusun::class, 'rusun_id', 'id');
    }

    public function tagihan()
    {
        return $this->hasMany(TagihanRusun::class, 'sewa_rusun_id', 'id');
    }
}
