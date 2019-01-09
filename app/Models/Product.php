<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'producttype_id','ivatype_id','unittype_id','trademark_id','code','product','description','image',
        'position','min_stock','max_stock','stock','last_cost','cost','last_price','price','expiration', 'cylindertype_id'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected $defaults = [
        'description'   => '',
        'image'         => '',
        'stock'         => 0,
        'position'      => '',
        'price'         => 0
    ];

    protected $casts = [
    ];

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
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            foreach ($model->defaults as $name => $value){
                if((isset($model->{$name}) && is_null($model->{$name})) || !isset($model->{$name})){
                    $model->{$name} = $value;
                }
            }
        });

        static::updating(function ($model){
            foreach ($model->defaults as $name => $value){
                if((isset($model->{$name}) && is_null($model->{$name})) || !isset($model->{$name})){
                    $model->{$name} = $value;
                }
            }
        });
    }

    public function producttype()
    {
        return $this->belongsTo('app\Models\Producttype');
    }

    public function ivatype()
    {
        return $this->belongsTo('app\Models\Ivatype');
    }

    public function trademark()
    {
        return $this->belongsTo('app\Models\Trademark');
    }

    public function unittype()
    {
        return $this->belongsTo('app\Models\Unittype');
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class);
    }

    public function giveProviderTo(Provider $provider)
    {
        return $this->providers()->save($provider);
    }

    
}
