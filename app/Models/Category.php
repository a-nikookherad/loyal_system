<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public function posts()
    {
        return $this->hasMany(Post::class, "category_id");
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, "attachable");
    }

    public function tages()
    {
        return $this->morphMany(Tag::class, "taggable");
    }
}
