<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
	use SoftDeletes;

    CONST STATUS = [
        'PENDIENTE'     => 4,
        'PAGO_PARCIAL'  => 5,
        'PAGO_TOTAL'    => 6,
        'REM_CERRADO'   => 25
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

    public function payments()
    {
        return $this->BelongsToMany(Payment::Class)
            ->withPivot(['payment_id','purchase_id','canceled','total','residue'])
            ->withTimestamps();
    }

}