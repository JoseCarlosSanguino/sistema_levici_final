<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ivatype extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'id','ivatype','percent'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function products()
    {
    	return $this->hasMany(Product::Class);
    }
}
