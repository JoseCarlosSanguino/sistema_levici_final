<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;
    //

    CONST STATUS=[
        
    ];

    protected $fillable = [
    	'bank_id','number','date_of','amount'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function bank()
    {
    	return $this->belongsTo(Bank::Class);
    }


    public function setDateofAttribute( $value ) {
        if(!is_null($value)){
            $newValue = explode('/',$value)[2] . '-' . explode('/',$value)[1] . '-' . explode('/',$value)[0];    
            $this->attributes['date_of'] = $newValue;
        }
        
    }

    public function getDateofAttribute( $value ) {
        if(!is_null($value)){
            return explode('-',$value)[2] . '/' . explode('-',$value)[1] . '/' . explode('-',$value)[0];
        }else{
            return null;
        }
    }


}
