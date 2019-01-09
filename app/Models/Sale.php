<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
	use SoftDeletes;

    CONST STATUS = [
        'REM_PENDIENTE'     => 14,
        'REM_CANCELADO'     => 15,
        'VTA_PENTIENTE'     => 1,
        'VTA_COBRO_PARCIAL' => 2,
        'VTA_COBRO_TOTAL'   => 3,
    ];

    CONST CONDITION = [
        'CTACTE' => 'cta cte',
        'CONTADO'=> 'contado'
    ];

	protected $table = 'sales';

	protected $fillable = [
        'id','operation_id','customer_id','cae_number','cae_expired','condition'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function operation()
    {
    	return $this->BelongsTo(Operation::Class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::Class);
    }

}