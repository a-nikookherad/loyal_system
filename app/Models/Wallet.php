<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    public function posts()
    {
        return $this->belongsToMany(Post::class, "costs", "wallet_id", "cost_id")
            ->withPivot([
                "price",
                "discount",
                "tax",
            ]);
    }

    public function costs()
    {
        return $this->hasMany(Cost::class, "wallet_id");
    }
}
