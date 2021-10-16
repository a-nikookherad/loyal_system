<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsCons extends Model
{
    use HasFactory;

    protected $fillable = [
        "type",
        "content",
    ];

    public function prosConsAble()
    {
        return $this->morphTo();
    }
}
