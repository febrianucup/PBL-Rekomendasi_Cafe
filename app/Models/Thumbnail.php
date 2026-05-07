<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Thumbnail extends Model
{
    protected $table='thumbnail_photo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cafe_id',
        'photo_url',
    ];

    public function cafes():BelongsTo{
        return $this->belongsTo(Cafes::class, 'cafe_id');
    }
}
