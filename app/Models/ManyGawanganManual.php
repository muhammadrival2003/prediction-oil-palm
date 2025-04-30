<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManyGawanganManual extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'blok_id',
        'tanggal',
        'rencana_gawangan',
        'realisasi_gawangan',
    ];

    public function getRencanaForMonth($month)
    {
        // Compare the month of the record's date with the provided month
        if (date('m', strtotime($this->tanggal)) == $month) {
            return $this->rencana_gawangan; // Use the correct property name
        }
        return 0;
    }

    public function getRealisasiForMonth($month)
    {
        // Compare the month of the record's date with the provided month
        if (date('m', strtotime($this->tanggal)) == $month) {
            return $this->realisasi_gawangan; // Use the correct property name
        }
        return 0;
    }

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }
}
