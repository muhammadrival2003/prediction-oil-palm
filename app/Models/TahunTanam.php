<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunTanam extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tahun_tanam'
    ];

    public function bloks()
    {
        return $this->hasMany(Blok::class);
    }
}
