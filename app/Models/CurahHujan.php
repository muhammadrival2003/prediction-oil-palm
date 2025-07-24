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

    protected static function booted()
    {
        static::created(function ($curahHujan) {
            self::updateDatasetSistem($curahHujan->tanggal);
        });

        static::updated(function ($curahHujan) {
            self::updateDatasetSistem($curahHujan->tanggal);
        });

        static::deleted(function ($curahHujan) {
            self::updateDatasetSistem($curahHujan->tanggal);
        });
    }

    // protected static function updateDatasetSistem($tanggal)
    // {
    //     $month = date('n', strtotime($tanggal));
    //     $year = date('Y', strtotime($tanggal));

    //     $totalCurahHujan = CurahHujan::whereMonth('tanggal', $month)
    //         ->whereYear('tanggal', $year)
    //         ->sum('curah_hujan');

    //     DatasetSistem::updateOrCreate(
    //         ['month' => $month, 'year' => $year],
    //         ['total_curah_hujan' => $totalCurahHujan]
    //     );
    // }

    protected static function updateDatasetSistem($tanggal)
    {
        $month = date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        $totalCurahHujan = self::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('curah_hujan');

        // Cari record dengan bulan dan tahun yang sama
        $existingRecord = DatasetSistem::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->first();

        if ($existingRecord) {
            // Update record yang sudah ada
            $existingRecord->update(['total_curah_hujan' => $totalCurahHujan]);
        } else {
            // Buat record baru dengan tanggal pertama bulan tersebut
            DatasetSistem::create([
                'tanggal' => date('Y-m-t', strtotime($tanggal)),
                'total_curah_hujan' => $totalCurahHujan
            ]);
        }
    }
}
