<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trademark extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'id','trademark'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
}
