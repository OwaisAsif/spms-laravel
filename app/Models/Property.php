<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'building_id';
    // protected $fillable = ['code'];
    protected $fillable = [
        'code', 'district', 'street', 'building', 'floor', 'flat', 'no_room', 
        'enter_password', 'building_created_at', 'block', 'cargo_lift', 'customer_lift', 
        'tf_hr', 'car_park', 'num_floors', 'ceiling_height', 'air_con_system', 'building_loading', 
        'display_by', 'individual', 'separate', 'year', 'agent_name', 'landlord_name', 
        'bank', 'bank_acc', 'management_company', 'remarks', 'landlord_created_at', 
        'facilities', 'types', 'decorations', 'usage', 'yt_link_1', 'yt_link_2', 
        'others', 'other_date', 'other_current_date', 'other_free_formate', 
        'gross_sf', 'net_sf', 'selling_price', 'selling_g', 'selling_n', 
        'rental_price', 'rental_g', 'rental_n', 'mgmf', 'rate', 'land', 'oths'
    ];
    protected $dates = ['deleted_at'];

    public function photos()
    {
        return $this->hasMany(Photo::class, 'code', 'code');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'code', 'code');
    }
}
