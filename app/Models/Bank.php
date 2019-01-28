<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'id','bank'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

}
