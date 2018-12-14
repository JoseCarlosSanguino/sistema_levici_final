<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unittype extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'id','unittype'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
}
