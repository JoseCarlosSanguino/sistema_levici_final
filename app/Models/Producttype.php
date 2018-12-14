<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producttype extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'id','producttype','rentable','salable'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)
        {
            if($model->rentable == 'on')
            {
                $model->rentable = 1;
            }
            else
            {
                $model->rentable = 0;
            }

            if($model->salable == 'on')
            {
                $model->salable = 1;
            }
            else
            {
                $model->salable = 0;
            }
        });

        static::updating(function ($model)
        {
            if($model->rentable == 'on')
            {
                $model->rentable = 1;
            }
            else
            {
                $model->rentable = 0;
            }
            
            if($model->salable == 'on')
            {
                $model->salable = 1;
            }
            else
            {
                $model->salable = 0;
            }
        });
    }

}
