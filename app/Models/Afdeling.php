<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Afdeling extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'nama'
    ];

    public function tahunTanams()
    {
        return $this->hasMany(TahunTanam::class, 'afdeling_id');
    }
    public function karyawanLapangans()
    {
        return $this->hasMany(KaryawanLapangan::class, 'afdeling_id');
    }
    
    public function users()
    {
        return $this->hasMany(User::class, 'afdeling_id');
    }
}
