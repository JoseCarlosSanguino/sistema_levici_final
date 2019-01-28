<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
	use SoftDeletes;

    CONST STATUS = [
        'COBRO_EMITIDO' => 19,
        'PAGO_EMITIDO'  => 20,
    ];

    protected $table = 'payments';

	protected $fillable = [
        'id','operation_id','customer_id', 'provider_id','cash','debit'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function operation()
    {
    	return $this->BelongsTo(Operation::Class);
    }

    public function sales()
    {
        return $this->BelongsToMany(Sale::Class)
            ->withPivot(['payment_id','sale_id','canceled','total','residue'])
            ->withTimestamps();
    }

    public function purchases()
    {
        return $this->BelongsToMany(Purchase::Class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::Class);
    }

    public function provider()
    {
        return $this->BelongsTo(Provider::Class);
    }

}