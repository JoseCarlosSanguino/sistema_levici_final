<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;
    //
    
    protected $fillable = [
        'province'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
}
