<?php

namespace App\Models;

use App\Http\Controllers\CafeController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationalTime extends Model
{
    protected $table='operational_hours';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cafe_id',
        'day_range',
        'open_time',
        'close_time',
    ];

    protected function cafes():BelongsTo{
        return $this->belongsTo(Cafes::class, 'cafe_id');
    }
}
