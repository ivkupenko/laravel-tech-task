<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Cart\Cart;
use App\Models\Users\Gender;
use App\Models\Users\Role;
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

    private function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function cartItemsCount()
    {
        $cart = $this->cart;
        return $cart ? $cart->items()->count() : 0;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender_id',
        'age',
        'role_id'
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

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ROLE_ADMIN);
    }

    public function isClient(): bool
    {
        return $this->hasRole(Role::ROLE_CLIENT);
    }
}
