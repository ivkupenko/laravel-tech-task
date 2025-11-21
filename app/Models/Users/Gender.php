<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['gender'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
