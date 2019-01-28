<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paycheck extends Model
{
    use SoftDeletes;
    //

    CONST STATUS=[
        'CARTERA'   => 16,
        'ENTREGADO' => 17,
        'DEPOSITADO'=> 18,
        'COBRADO'	=> 21
    ];

    protected $fillable = [
    	'bank_id','status_id','type','number','receipt','paymentdate','expiration','amount','owner_name','owner_cuit','observation'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function status()
    {
    	return $this->belongsTo(Status::Class);
    }

    public function operations()
    {
    	return $this->belongsToMany(Operation::Class)
    		->withTimestamps();
    }

    public function setPaymentdateAttribute( $value ) {
        if(!is_null($value)){
            $newValue = explode('/',$value)[2] . '-' . explode('/',$value)[1] . '-' . explode('/',$value)[0];    
            $this->attributes['paymentdate'] = $newValue;
        }
        
    }

    public function getPaymentdateAttribute( $value ) {
        if(!is_null($value)){
            return explode('-',$value)[2] . '/' . explode('-',$value)[1] . '/' . explode('-',$value)[0];
        }else{
            return null;
        }
    }

    public function setReceiptAttribute( $value ) {
        if(!is_null($value)){
            $newValue = explode('/',$value)[2] . '-' . explode('/',$value)[1] . '-' . explode('/',$value)[0];    
            $this->attributes['receipt'] = $newValue;
        }
        
    }

    public function getReceiptAttribute( $value ) {
        if(!is_null($value)){
            return explode('-',$value)[2] . '/' . explode('-',$value)[1] . '/' . explode('-',$value)[0];
        }else{
            return null;
        }
    }

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
    

}
