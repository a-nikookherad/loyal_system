<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    public function rateable()
    {
        return $this->morphTo();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, "post_relates", "related_id", "post_id")->withPivot("title");
    }
}
