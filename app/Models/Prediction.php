<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prediction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'year',
        'month',
        'prediction',
        'input_data'
    ];
    
    protected $casts = [
        'input_data' => 'array'
    ];
    
    public function getMonthNameAttribute()
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ][$this->month] ?? 'Unknown';
    }
}