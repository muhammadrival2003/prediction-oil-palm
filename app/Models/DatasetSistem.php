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
        'month',
        'year',
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
        'month' => 'integer',
        'year' => 'integer',
        'total_curah_hujan' => 'decimal:2',
        'total_pemupukan' => 'decimal:2',
        'total_hasil_produksi' => 'decimal:2',
    ];

    /**
     * Get the month name attribute
     *
     * @return string
     */
    public function getNamaBulanAttribute()
    {
        return \DateTime::createFromFormat('!m', $this->month)->format('F');
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