<?php

namespace app\Models;

class Provider extends Person
{

    protected $table = 'persons';

    protected $fillable = [
        'ivacondition_id','persontype_id','province_id','city_id','cuit','name','address','telephone','web','markup', 'email', 'observation'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('persontype_id', 2);
        });
    }


}
