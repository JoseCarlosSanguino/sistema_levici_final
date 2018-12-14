<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'id','city','province_id'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];


    function province()
    {
        return $this->belongsTo('app\Models\Province');
    }
}
