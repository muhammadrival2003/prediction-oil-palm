<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManyGawanganManual extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'blok_id',
        'tanggal',
        'rencana_gawangan',
        'realisasi_gawangan',
    ];

    public function blok() 
    {
        return $this->belongsTo(Blok::class);
    }
}
