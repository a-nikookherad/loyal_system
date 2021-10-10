<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "country",
        "state",
        "city",
        "address",
        "postal_code",
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
