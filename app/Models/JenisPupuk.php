<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPupuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_pupuks';

    protected $fillable = [
        'nama',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relasi ke tabel pemupukans
     */
    public function pemupukans(): HasMany
    {
        return $this->hasMany(Pemupukan::class, 'jenis_pupuk_id');
    }
}