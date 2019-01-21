<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cylindermove extends Model
{
    use softDeletes;
    //

    CONST MOVETYPE = [
        'ENVIO_A_CLIENTE'   => 1,
        'ENVIO_A_PROVEEDOR' => 2,
        'EN_DEPOSITO'       => 3,
    ];

    protected $fillable = ['id','movetype_id','cylinder_id','person_id','date_of'];

    protected $hidden = ['created_at','updated_at','deleted_at'];


    public function setDateofAttribute( $value ) {

        if(!is_null($value)){
            $date = explode(' ', $value)[0];
            $hour = explode(' ', $value)[1];
            $newValue = explode('/',$date)[2] . '-' . explode('/',$date)[1] . '-' . explode('/',$date)[0] . ' ' . $hour;
            $this->attributes['date_of'] = $newValue;
        }
    }

    public function getDateofAttribute( $value ) {
        if(!is_null($value)){
            $date = explode(' ', $value)[0];
            $hour = explode(' ', $value)[1];
            return explode('-',$date)[2] . '/' . explode('-',$date)[1] . '/' . explode('-',$date)[0] . ' ' . $hour;
        }else{
            return null;
        }
    }

    public function getFullNumberAttribute(){
        return str_pad($this->pointofsale,4,0,STR_PAD_LEFT) . '-' . str_pad($this->number, 9,0,STR_PAD_LEFT);
    }


    public function movetype()
    {
        return $this->belongsTo(Movetype::Class);
    }

    public function cylinder()
    {
        return $this->belongsTo(Cylinder::Class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::Class, 'customer_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::Class, 'person_id');
    }
}