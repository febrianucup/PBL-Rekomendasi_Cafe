<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CafePhoto extends Model
{
    protected $table='cafe_photos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cafe_id',
        'photo_url',
        'is_primary',
    ];

    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafes::class, 'cafe_id');
    }
}
