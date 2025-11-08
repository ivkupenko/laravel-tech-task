<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Filterable;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender_id',
        'age',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
