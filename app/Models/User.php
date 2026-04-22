<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'role_id',
        'username',
        'password',
        'email',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array{
        return [
            'password' => 'hashed',
        ];
    }

    public function role():BelongsTo{
        return $this->belongsTo(Role::class);
    }

    public function ownerProfile():HasOne{
        return $this->HasOne(OwnerProfile::class, 'user_id');
    }
}
