<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Cafes;
use Carbon\Carbon;

class Promosi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'img_url',
        'cafe_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->img_url ? asset('storage/' . $this->img_url) : null;
    }

    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafes::class, 'cafe_id');
    }

    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)
                     ->where('end_date', '>=', $now);
    }
}
