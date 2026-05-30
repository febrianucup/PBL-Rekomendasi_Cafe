<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeView extends Model
{
    public $fillable = [
        'cafe_id',
        'user_id',
        'ip_address',
        'session_id',
    ];
}
