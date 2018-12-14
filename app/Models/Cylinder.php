<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cylinder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code','external_code','cylindertype_id','expiration','is_own','provider_id', 'observation'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected $casts = [];

    public function setExpirationAttribute( $value ) {
        if(!is_null($value)){
            $newValue = explode('/',$value)[2] . '-' . explode('/',$value)[1] . '-' . explode('/',$value)[0];    
            $this->attributes['expiration'] = $newValue;
        }
    }

    public function getExpirationAttribute( $value ) {
        if(!is_null($value)){
            return explode('-',$value)[2] . '/' . explode('-',$value)[1] . '/' . explode('-',$value)[0];
        }else{
            return null;
        }
    }

    public function provider()
    {
        return $this->belongsTo('app\Models\Provider');
    }

    public function cylindertype()
    {
        return $this->belongsTo('app\Models\Cylindertype');
    }

    public function cylindermoves()
    {
        return $this->hasMany('app\Models\Cylindermove');
    }

    public function operations()
    {
        return $this->belongsToMany('app\Models\Operation');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            if($model->is_own == 'on'){
                $model->is_own = 1;
                $model->provider_id = null;
            }else{
                $model->is_own = 0;
            }
        });

        static::updating(function ($model){
            if($model->is_own == 'on'){
                $model->is_own = 1;
                $model->provider_id = null;
            }else{
                $model->is_own = 0;
            }
        });
        
    }
}
