<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //


    public function users()
    {
        return $this
            ->belongsToMany('app\User')
            ->withTimestamps();
    }
}
