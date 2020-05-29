<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id','operationtype_id','status_id','user_id','pointofsale','number','dateof','amount','discount','iva105','iva21','observation','order_number'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function setDateofAttribute( $value ) {
        if(!is_null($value)){
            $newValue = explode('/',$value)[2] . '-' . explode('/',$value)[1] . '-' . explode('/',$value)[0];    
            $this->attributes['dateof'] = $newValue;
        }
    }

    public function getDateofAttribute( $value ) {
        if(!is_null($value)){
            $date = explode(' ', $value)[0];
            return explode('-',$date)[2] . '/' . explode('-',$date)[1] . '/' . explode('-',$date)[0];
        }else{
            return null;
        }
    }

    public function getFullNumberAttribute(){
        return str_pad($this->pointofsale,4,0,STR_PAD_LEFT) . '-' . str_pad($this->number, 8,0,STR_PAD_LEFT);
    }

    public function getFullNumberAttributeType(){
        return $this->operationtype->groupoperationtype->abreb . str_pad($this->pointofsale,4,0,STR_PAD_LEFT) . '-' . str_pad($this->number, 8,0,STR_PAD_LEFT);
    }


    public function products()
    {
        return $this->belongsToMany(Product::Class)
            ->withPivot(['price', 'quantity','iva','discount', 'product_id','operation_id'])->withTimestamps();
    }

    public function paychecks()
    {
        return $this->belongsToMany(Paycheck::Class)->withTimestamps();
    }

    public function transfers()
    {
        return $this->belongsToMany(Transfer::Class)->withTimestamps();
    }

    public function cylinders()
    {
        return $this->belongsToMany(Cylinder::Class, 'operation_cylinder')
            ->withPivot(['cylinder_id','operation_id'])->withTimestamps();
    }

    public function operationtype()
    {
    	return $this->belongsTo(Operationtype::Class);
    }

    public function status()
    {
    	return $this->belongsTo(Status::Class, 'status_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::Class);
    }

    public function sale()
    {
        return $this->hasOne(Sale::Class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::Class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::Class);
    }

    

}