<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{

    use SoftDeletes;

    protected $table = 'persons';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ivacondition_id','province_id','city_id','cuit','name','address','telephone','web','markup'
    ];

    protected $attributes = [
        'persontype_id' => 2
    ];

    public function province()
    {
        return $this->belongsTo('app\Models\Province');
    }

    public function ivacondition()
    {
        return $this->belongsTo('app\Models\Ivacondition');
    }

}
