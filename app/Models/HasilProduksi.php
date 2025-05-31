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

    protected static function updateDatasetSistem($tanggal)
    {
        $month = date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        $totalProduksi = HasilProduksi::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('realisasi_produksi');

        DatasetSistem::updateOrCreate(
            ['month' => $month, 'year' => $year],
            ['total_hasil_produksi' => $totalProduksi]
        );
    }
}
