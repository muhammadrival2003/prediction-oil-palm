<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemupukan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blok_id',
        'tanggal',
        'dosis',
        'volume'
    ];

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }

    protected static function booted()
    {
        static::created(function ($pemupukan) {
            self::updateDatasetSistem($pemupukan->tanggal);
        });

        static::updated(function ($pemupukan) {
            self::updateDatasetSistem($pemupukan->tanggal);
        });

        static::deleted(function ($pemupukan) {
            self::updateDatasetSistem($pemupukan->tanggal);
        });
    }

    protected static function updateDatasetSistem($tanggal)
    {
        $month = date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        $totalVolume = Pemupukan::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('volume');

        DatasetSistem::updateOrCreate(
            ['month' => $month, 'year' => $year],
            ['total_pemupukan' => $totalVolume]
        );
    }
}
