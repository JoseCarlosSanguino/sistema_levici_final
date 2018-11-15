<?php

use Illuminate\Database\Seeder;
use app\Model\Operationtype;

class OperationtypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new Operationtype();
        $obj->operationtype = 'FACTURA VENTA A';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'FACTURA VENTA B';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'FACTURA VENTA B';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'FACTURA COMPRA A';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'FACTURA COMPRA B';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'FACTURA COMPRA C';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'DEVOLUCION PROVEEDOR';
        $obj->is_fiscal = 0;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'DEVOLUCION CLIENTE';
        $obj->is_fiscal = 0;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'PRESUPUESTO';
        $obj->is_fiscal = 0;
        $obj->stock_affected = 0;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'RECIBO PROVEEDOR';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 0;
        $obj->save();
        
        $obj = new Operationtype();
        $obj->operationtype = 'RECIBO CLIENTE';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 0;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'REMITO PROVEEDOR';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 1;
        $obj->save();

        $obj = new Operationtype();
        $obj->operationtype = 'REMITO CLIENTE';
        $obj->is_fiscal = 1;
        $obj->stock_affected = 1;
        $obj->save();
        
    }
}
