<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chemis extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blok_id',
        'tanggal',
        'jumlah_pokok'
    ];

    public function blok() 
    {
        return $this->belongsTo(Blok::class);
    }
}
