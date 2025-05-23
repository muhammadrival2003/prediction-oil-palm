<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blok_id',
        'year',
        'month',
        'rainfall',
        'fertilizer',
        'production'
    ];

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }

    public static function getLast12Months()
    {
        return self::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get()
            ->sortBy(function ($item) {
                return $item->year * 100 + $item->month;
            })
            ->values();
    }
}
