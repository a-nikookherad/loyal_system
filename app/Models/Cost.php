<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    use HasFactory, SoftDeletes;


    public function post()
    {
        return $this->belongsTo(Post::class, "post_id");
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, "wallet_id");
    }
}
