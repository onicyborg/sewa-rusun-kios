<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanikal extends Model
{
    use HasFactory;

    protected $table = 'mekanikals';

    protected $fillable = [
        'name',
        'no_hp'
    ];
}
