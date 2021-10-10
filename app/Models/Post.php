<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    public function relates()
    {
        return $this->belongsToMany(Rate::class, "post_relates", "post_id", "related_id")->withPivot("title");
    }

    public function wallets()
    {
        return $this->belongsToMany(Wallet::class, "costs", "cost_id", "wallet_id")
            ->withPivot([
                "price",
                "discount",
                "tax",
            ]);
    }

    public function costs()
    {
        return $this->hasMany(Cost::class, "post_id");
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, "attachable");
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, "commentable");
    }

    public function rates()
    {
        return $this->morphMany(Rate::class, "rateable");
    }

    public function tages()
    {
        return $this->morphMany(Tag::class, "taggable");
    }

    public function views()
    {
        return $this->morphMany(View::class, "viewable");
    }
}
