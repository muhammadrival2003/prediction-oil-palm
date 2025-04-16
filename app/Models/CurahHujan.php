<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurahHujan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tanggal',
        'curah_hujan'
    ];

    public function blok() 
    {
        return $this->belongsTo(Blok::class);
    }
}
