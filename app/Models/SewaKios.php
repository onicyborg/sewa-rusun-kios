<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaKios extends Model
{
    use HasFactory;

    protected $table = 'sewa_kios';
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

    public function kios()
    {
        return $this->belongsTo(Kios::class, 'kios_id', 'id');
    }

    public function tagihan()
    {
        return $this->hasMany(TagihanKios::class, 'sewa_kios_id', 'id');
    }
}
