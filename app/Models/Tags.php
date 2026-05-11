<?php

namespace App\Models;

use App\Models\Cafes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Tags extends Model
{
    use HasFactory, Notifiable;

    protected $table='tags';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tag_name'
    ];

    public function cafes(): BelongsToMany
    {
        return $this->belongsToMany(Cafes::class, 'cafe_tag', 'tag_id', 'cafe_id');
    }
}
