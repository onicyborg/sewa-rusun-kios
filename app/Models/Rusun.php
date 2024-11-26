<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rusun extends Model
{
    use HasFactory;

    protected $table = 'rusuns';

    protected $fillable = ['nomor_rusun', 'lantai', 'tower', 'harga_sewa'];

    public function sewa_rusun()
    {
        return $this->hasMany(SewaRusun::class, 'rusun_id', 'id');
    }
}
