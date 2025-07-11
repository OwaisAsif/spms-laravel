<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'image',
        'code',
        'uuid',
    ];
    protected $dates = ['deleted_at'];

    public function property()
    {
        return $this->belongsTo(Property::class, 'code', 'code');
    }
}
