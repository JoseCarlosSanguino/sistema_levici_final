<?php

use Illuminate\Database\Seeder;
use app\Models\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new Status();
        $obj->status = 'VENTA PENDEINTE COBRO';
        $obj->save();
        
        $obj = new Status();
        $obj->status = 'VENTA COBRO PARCIAL';
        $obj->save();
        
        $obj = new Status();
        $obj->status = 'VENTA COBRO TOTAL';
        $obj->save();
        
        $obj = new Status();
        $obj->status = 'COMPRA PENDIENTE DE PAGO';
        $obj->save();
        
        $obj = new Status();
        $obj->status = 'COMPRA PAGO PARCIAL';
        $obj->save();
        
        $obj = new Status();
        $obj->status = 'COMPRA PAGO TOTAL';
        $obj->save();
        
        $obj = new Status();
        $obj->status = 'PRESUPUESTO RECHAZADO';
        $obj->save();
        
        $obj = new Status();
        $obj->status = 'PRESUPUESTO APROBADO';
        $obj->save();
        
        $obj = new Status();
        $obj->status = 'PRESUPUESTO ENVIADO';
        $obj->save();
        
        
    }
}
