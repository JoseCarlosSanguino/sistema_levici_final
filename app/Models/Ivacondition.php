<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Ivacondition extends Model
{
    //


    public function operationtypes()
    {
    	return $this->belongsToMany(Operationtype::Class)
    		->withPivot('Operationtype_id','ivacondition_id')
    		->withTimestamps();
    }
}
