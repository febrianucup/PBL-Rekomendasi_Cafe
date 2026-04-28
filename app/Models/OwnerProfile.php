<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerProfile extends Model
{
    protected $table = 'owner';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'cafe_name',
        'address',
    ];

    protected function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
