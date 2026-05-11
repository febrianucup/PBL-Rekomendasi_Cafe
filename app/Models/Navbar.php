<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    protected $fillable = ['title', 'url', 'sort_order', 'is_active'];
}
