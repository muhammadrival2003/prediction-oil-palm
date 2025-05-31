<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KaryawanLapangan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'karyawan_lapangans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'afdeling_id',
        'nama',
        'jabatan',
        'tanggal_masuk',
        'lokasi_kerja'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    /**
     * Jabatan yang tersedia untuk karyawan.
     *
     * @var array
     */
    public const JABATAN = [
        'MDR Panen' => 'MDR Panen',
        'MDR Pemeliharaan' => 'MDR Pemeliharaan',
        'Petugas Timbang BRD' => 'Petugas Timbang BRD',
        'Mandor' => 'Mandor',
        'Asisten Kebun' => 'Asisten Kebun',
    ];

    /**
     * Get the afdeling that owns the karyawan.
     */
    public function afdeling()
    {
        return $this->belongsTo(Afdeling::class);
    }

    /**
     * Scope query untuk MDR Panen.
     */
    public function scopeMdrPanen($query)
    {
        return $query->where('jabatan', 'MDR Panen');
    }

    /**
     * Scope query untuk MDR Pemeliharaan.
     */
    public function scopeMdrPemeliharaan($query)
    {
        return $query->where('jabatan', 'MDR Pemeliharaan');
    }

    /**
     * Scope query untuk Petugas Timbang BRD.
     */
    public function scopePetugasTimbangBrd($query)
    {
        return $query->where('jabatan', 'Petugas Timbang BRD');
    }

    /**
     * Hitung lama kerja dalam tahun.
     */
    public function getLamaKerjaAttribute()
    {
        return $this->tanggal_masuk->diffInYears(now());
    }
}