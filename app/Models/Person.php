<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;

    protected $table = 'persons';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    

  
    public function province()
    {
        return $this->belongsTo('app\Models\Province');
    }

    public function ivacondition()
    {
        return $this->belongsTo('app\Models\Ivacondition');
    }

}
