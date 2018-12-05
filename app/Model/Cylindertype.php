<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeleted;

class CylinderTYpe extends Model
{
    use softDeleted;
    //

    protected $fillables = ['id','cylindertype'];

    protected $hidden = ['created_at','updated_at','deleted_at'];
}
