<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Afdeling extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama'
    ];

    public function tahunTanams()
    {
        return $this->hasMany(TahunTanam::class, 'afdeling_id');
    }
}
