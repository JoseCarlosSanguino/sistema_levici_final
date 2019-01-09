<?php

use Illuminate\Database\Seeder;
use app\Models\Unittype;

class UnittypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new Unittype();
        $obj->unittype = 'UNIDADES';
        $obj->save();

        $obj = new Unittype();
        $obj->unittype = 'LITROS';
        $obj->save();

        $obj = new Unittype();
        $obj->unittype = 'KILOS';
        $obj->save();

        $obj = new Unittype();
        $obj->unittype = 'GRAMOS';
        $obj->save();

        $obj = new Unittype();
        $obj->unittype = 'METROS CUBICOS';
        $obj->save();

        
    }
}
