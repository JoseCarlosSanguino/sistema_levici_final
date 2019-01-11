<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cylindertype extends Model
{
    use softDeletes;
    //

    protected $fillable = ['id','cylindertype'];

    protected $hidden = ['created_at','updated_at','deleted_at'];
}