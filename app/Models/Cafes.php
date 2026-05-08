<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cafes extends Model
{
    protected $table='cafes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'user_id',
        'description',
        'type_id',
        'num_phone',
        'email',
        'address',
        'latitude',
        'longitude',
        'maps_link',
        'kecamatan',
    ];

    public function type():BelongsTo{
        return $this->belongsTo(Type::class, 'type_id');
    }    

    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tags::class, 'cafe_tag', 'cafe_id', 'tag_id');
    }

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photos():HasMany{
        return $this->hasMany(CafePhoto::class, 'cafe_id');
    }

    public function thumbnail():HasOne{
        return $this->hasOne(Thumbnail::class, 'cafe_id');
    }

    public function operationalTime():HasMany{
        return $this->hasMany(OperationalTime::class, 'cafe_id');
    }

    public function menuItems():HasMany{
        return $this->hasMany(Menu::class, 'cafe_id');
    }
}
