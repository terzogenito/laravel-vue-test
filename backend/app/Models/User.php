<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function getJWTIdentifier(): string
    {
        return $this->getKey();
    }

    
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
