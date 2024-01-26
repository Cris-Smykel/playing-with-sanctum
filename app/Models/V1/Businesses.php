<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Businesses extends Model
{
    use HasFactory;

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
