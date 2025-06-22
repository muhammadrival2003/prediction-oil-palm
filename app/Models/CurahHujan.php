<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurahHujan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tanggal',
        'curah_hujan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function blok() 
    {
        return $this->belongsTo(Blok::class);
    }

    protected static function updateDatasetSistem($tanggal)
    {
        $month = date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        $totalCurahHujan = CurahHujan::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('curah_hujan');

        DatasetSistem::updateOrCreate(
            ['month' => $month, 'year' => $year],
            ['total_curah_hujan' => $totalCurahHujan]
        );
    }
}