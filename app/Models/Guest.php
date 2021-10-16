<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        "full_name",
        "ip",
        "cookie",
        "show_name",
        "email",
        "mobile",
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, "guest_id");
    }
}
