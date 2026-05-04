<?php

namespace App\Models;

use App\Models\Cafes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $table='types';
    protected $primaryKey = 'id';

    protected $fillable = ['type_name'];

    public function cafes(): HasMany
    {
        return $this->hasMany(Cafes::class, 'type_id');
    }
}
