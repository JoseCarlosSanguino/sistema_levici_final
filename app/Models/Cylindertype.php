<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cylindertype extends Model
{
    use softDeletes;
    //

    protected $fillable = ['id','cylindertype', 'capacity'];

    protected $hidden = ['created_at','updated_at','deleted_at'];


    public function products()
    {
        return $this->belongsToMany(Product::Class);
    }

    public function giveProductTo(Cylindertype $product)
    {
        return $this->products()->save($product);
    }
}
