<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = ['user_id', 'cafe_id', 'parent_id', 'body', 'rating_score', 'images', 'type'];

    protected $cast = [
        'rating_score'=>'float'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->oldest();
    }

    public function cafe():BelongsTo{
        return $this->belongsTo(Cafes::class, 'cafe_id');
    }

    public function scopeReviews($query) { 
        return $query->where('type', 'review'); 
    }

    public function scopeDiscussions($query) { 
        return $query->where('type', 'discussion'); 
    }
}