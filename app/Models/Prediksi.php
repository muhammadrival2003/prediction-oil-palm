<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prediksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prediksi';

    protected $fillable = [
        'blok_id',
        'tanggal',
        'hasil_prediksi'
    ];

    public function blok() 
    {
        return $this->belongsTo(Blok::class);
    }
}
