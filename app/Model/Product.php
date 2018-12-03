<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'producttype_id','ivatype_id','unittype_id','trademark_id','code','product','description','image','position','min_stock','max_stock','stock','last_cost','cost','last_price','price'
    ];

    protected $defaults = [
        'description'   => '',
        'image'         => '',
        'stock'         => 0,
        'position'      => '',
        'price'         => 0
    ];
    
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
        return $this->belongsTo('app\Model\Producttype');
    }

    public function ivatype()
    {
        return $this->belongsTo('app\Model\Ivatype');
    }

    public function trademark()
    {
        return $this->belongsTo('app\Model\Trademark');
    }

    public function unittype()
    {
        return $this->belongsTo('app\Model\Unittype');
    }

    
}
