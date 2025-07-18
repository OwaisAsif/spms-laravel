<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function property()
    {
        return $this->belongsTo(Property::class, 'code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
