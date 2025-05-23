<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
        'blok_id',
        'data', // JSON field untuk menyimpan data tambahan
        'ip_address'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }
}