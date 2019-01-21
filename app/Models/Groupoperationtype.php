<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Groupoperationtype extends Model
{
    //

    public function operationtypes()
    {
    	return $this->hasMany(Operationtype::Class);
    }
}
