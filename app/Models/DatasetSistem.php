<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatasetSistem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal',
        'total_curah_hujan',
        'total_pemupukan',
        'total_hasil_produksi',
    ];

    /**
     * Casting attributes to native types
     *
     * @var array
     */
    protected $casts = [
        'tanggal' => 'date',
        'total_curah_hujan' => 'decimal:2',
        'total_pemupukan' => 'decimal:2',
        'total_hasil_produksi' => 'decimal:2',
    ];

    /**
     * Get the month attribute from tanggal
     *
     * @return int
     */
    public function getMonthAttribute()
    {
        return $this->tanggal->format('n');
    }

    /**
     * Get the year attribute from tanggal
     *
     * @return int
     */
    public function getYearAttribute()
    {
        return $this->tanggal->format('Y');
    }

    /**
     * Get the month name attribute
     *
     * @return string
     */
    public function getNamaBulanAttribute()
    {
        return $this->tanggal->format('F');
    }

    /**
     * Get the period in format "Bulan Tahun" (e.g. "Januari 2023")
     *
     * @return string
     */
    public function getPeriodeAttribute()
    {
        return $this->nama_bulan . ' ' . $this->year;
    }
}