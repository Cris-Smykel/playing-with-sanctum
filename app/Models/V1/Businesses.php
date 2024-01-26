<?php

namespace App\Models\V1;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Businesses extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        "name",
        "email",
        "password",
    ];

    public function Clients()
    {
        return $this->hasMany(Clients::class, "business_id", "id");
    }
}
