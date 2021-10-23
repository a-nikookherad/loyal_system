<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "slug",
        "canonical",
        "title",
        "description",
        "subtitle",
        "summery",
        "content",
        "category_id",
        "author_id",
        "status",
        "visibility",
        "order",
        "extra",
        "published_at",
        "expired_at",
        "parent_id",
        "update_id",
    ];

    protected $with = ["children"];
    protected $withCount = ["views"];

    public function children()
    {
        return $this->hasMany(Post::class, "parent_id");
    }

    public function parent()
    {
        return $this->belongsTo(Post::class, "parent_id");
    }

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
        return $this->hasMany(Comment::class, "post_id");
    }

    public function rates()
    {
        return $this->morphMany(Rate::class, "rateable");
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, "taggable");
    }

    public function views()
    {
        return $this->morphMany(View::class, "viewable");
    }

    public function metaTags()
    {
        return $this->hasMany(MetaTag::class, "post_id");
    }

    public function hero()
    {
        return $this->hasOne(Hero::class, "post_id");
    }
}
