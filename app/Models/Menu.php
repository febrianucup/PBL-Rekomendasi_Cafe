<?php

namespace App\Models;

use App\Http\Controllers\CafeController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $table='menu_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cafe_id',
        'name',
        'description',
        'price',
        'img_url',
    ];

    protected function cafes():BelongsTo{
        return $this->belongsTo(Cafes::class, 'cafe_id');
    }
}
