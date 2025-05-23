<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blok extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_blok',
        'luas_lahan',
        'tahun_tanam_id',
        'jumlah_pokok'
    ];

    public function tahunTanam()
    {
        return $this->belongsTo(TahunTanam::class);
    }

    public function activitylogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
    public function pemupukans()
    {
        return $this->hasMany(Pemupukan::class);
    }
    public function chemis()
    {
        return $this->hasMany(Chemis::class);
    }
    public function many_gawangan_manuals()
    {
        return $this->hasMany(ManyGawanganManual::class);
    }
    public function curah_hujans()
    {
        return $this->hasMany(CurahHujan::class);
    }
    public function produksis()
    {
        return $this->hasMany(Produksi::class);
    }
    public function prediksis()
    {
        return $this->hasMany(Prediksi::class);
    }
}
