<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

    protected $table = 'persons';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ivacondition_id','province_id','city_id','cuit','provider','address','telephone','web','markup'
    ];

    protected $attributes = [
        'persontype_id' => 2
    ];

}
