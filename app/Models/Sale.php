<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
	use SoftDeletes;

    CONST STATUS = [
       /* 'REM_PENDIENTE'     => 14,
        'REM_CANCELADO'     => 15,*/
        'REM_ANULADO'       => 27,
       /* 'VTA_PENTIENTE'     => 1,
        'VTA_COBRO_PARCIAL' => 2,
        'VTA_COBRO_TOTAL'   => 3,
        'PRESU_PENDIENTE'   => 23,
        'PRESU_RECHAZADO'   => 24,
        'REC_CILINDRO_OK'   => 26*/
    ];

    CONST CONDITION = [
        'CTACTE' => 'cta cte',
        'CONTADO'=> 'contado'
    ];

	protected $table = 'sales';

	protected $fillable = [
        'id','operation_id','customer_id','cae_number','cae_expired','conditions'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function getCaeExpiredAttribute( $value ) {
        if(!is_null($value) && $value != ""){
            $date = explode(' ', $value)[0];
            return explode('-',$date)[2] . '/' . explode('-',$date)[1] . '/' . explode('-',$date)[0];
        }else{
            return null;
        }
    }

    public function operation()
    {
    	return $this->BelongsTo(Operation::Class);
    }

    public function customer()
    {
        return $this->BelongsTo(Customer::Class);
    }

    public function payments()
    {
        return $this->BelongsToMany(Payment::Class)
            ->withPivot(['payment_id','sale_id','canceled','total','residue'])
            ->withTimestamps();
    }

}