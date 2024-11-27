<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    use HasFactory;

    protected $table = 'kios';

    protected $fillable = ['nama_kios', 'harga_kios'];

    public function sewa_kios()
    {
        return $this->hasMany(SewaKios::class, 'kios_id', 'id');
    }
}
