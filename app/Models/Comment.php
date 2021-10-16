<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "show_name",
        "title",
        "description",
        "status",
        "post_id",
        "parent_id",
        "user_id",
        "guest_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function children()
    {
        return $this->hasMany(Comment::class, "parent_id");
    }

    public function likes()
    {
        return $this->morphMany(Like::class, "likeable");
    }

    public function prosConses()
    {
        return $this->hasMany(ProsCons::class, "comment_id");
    }
}
