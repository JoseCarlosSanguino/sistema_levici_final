<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Operationtype extends Model
{
    //


    public function ivaconditions()
    {
    	return $this->belongsToMany(Ivacondition::Class)
    		->withPivot('Operationtype_id','ivacondition_id')
    		->withTimestamps();
    }

    public function groupoperationtype()
    {
    	return $this->belongsTo(Groupoperationtype::Class);
    }
}
