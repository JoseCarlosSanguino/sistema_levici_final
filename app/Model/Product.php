<?php

namespace app\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'producttype_id','ivatype_id','unittype_id','trademark_id','code','product','description','image','position','min_stock','max_stock','stock','last_cost','cost','last_price','price'
    ];
}
