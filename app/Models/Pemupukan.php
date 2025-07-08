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
        'jenis_pupuk_id',
        'tanggal',
        'dosis',
        'volume'
    ];

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }

    public function jenisPupuk()
    {
        return $this->belongsTo(JenisPupuk::class, 'jenis_pupuk_id');
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

        $totalProduksi = Pemupukan::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('volume');

        // Cari record dengan bulan dan tahun yang sama
        $existingRecord = DatasetSistem::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->first();

        if ($existingRecord) {
            // Update record yang sudah ada
            $existingRecord->update(['total_pemupukan' => $totalProduksi]);
        } else {
            // Buat record baru dengan tanggal pertama bulan tersebut
            DatasetSistem::create([
                'tanggal' => date('Y-m-01', strtotime($tanggal)),
                'total_pemupukan' => $totalProduksi
            ]);
        }
    }
}
