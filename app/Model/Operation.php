<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id','operationtype_id','status_id','user_id','number','date_of','amount','discount','observation'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

}