<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HasilProduksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blok_id',
        'tanggal',
        'rencana_produksi',
        'realisasi_produksi'
    ];

    public function blok(): BelongsTo
    {
        return $this->belongsTo(Blok::class);
    }

    protected static function booted()
    {
        static::created(function ($hasilProduksi) {
            self::updateDatasetSistem($hasilProduksi->tanggal);
        });

        static::updated(function ($hasilProduksi) {
            self::updateDatasetSistem($hasilProduksi->tanggal);
        });

        static::deleted(function ($hasilProduksi) {
            self::updateDatasetSistem($hasilProduksi->tanggal);
        });
    }

    // Models/HasilProduksi.php
    protected static function updateDatasetSistem($tanggal)
    {
        $month = date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        $totalProduksi = self::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('realisasi_produksi');

        // Cari record dengan bulan dan tahun yang sama
        $existingRecord = DatasetSistem::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->first();

        if ($existingRecord) {
            // Update record yang sudah ada
            $existingRecord->update(['total_hasil_produksi' => $totalProduksi]);
        } else {
            // Buat record baru dengan tanggal pertama bulan tersebut
            DatasetSistem::create([
                'tanggal' => date('Y-m-01', strtotime($tanggal)),
                'total_hasil_produksi' => $totalProduksi
            ]);
        }
    }
}
