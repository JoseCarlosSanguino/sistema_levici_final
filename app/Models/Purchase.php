<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
	use SoftDeletes;

    CONST STATUS = [
        'COMPRA PENDIENTE DE PAGO'  => 4,
        'COMPRA PAGO PARCIAL'       => 5,
        'COMPRA PAGO TOTAL'         => 6
    ];

    CONST CONDITION = [
        'CTACTE' => 'cta cte',
        'CONTADO'=> 'contado'
    ];

	protected $fillable = [
        'id','operation_id','provider_id','cae_number','cae_expired','conditions'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function operation()
    {
    	return $this->BelongsTo(Operation::Class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::Class);
    }

}