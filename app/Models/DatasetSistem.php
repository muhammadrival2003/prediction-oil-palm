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
        'bulan',
        'tahun',
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
     * Boot the model and set up event listeners
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // If bulan and tahun are provided but tanggal is not, create tanggal
            if (isset($model->attributes['bulan']) && isset($model->attributes['tahun']) && !isset($model->attributes['tanggal'])) {
                $bulan = $model->attributes['bulan'];
                $tahun = $model->attributes['tahun'];
                $model->attributes['tanggal'] = sprintf('%04d-%02d-01', $tahun, $bulan);
            }
            
            // Remove bulan and tahun from attributes as they are not database columns
            unset($model->attributes['bulan']);
            unset($model->attributes['tahun']);
        });
    }

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
     * Get the bulan attribute from tanggal
     *
     * @return int|null
     */
    public function getBulanAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('n') : null;
    }

    /**
     * Get the tahun attribute from tanggal
     *
     * @return int|null
     */
    public function getTahunAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('Y') : null;
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