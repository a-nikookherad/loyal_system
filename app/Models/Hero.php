<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    public function attachments()
    {
        return $this->morphMany(Attachment::class,"attachable");
    }
}
