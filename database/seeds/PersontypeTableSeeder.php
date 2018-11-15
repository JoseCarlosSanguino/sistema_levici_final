<?php

use Illuminate\Database\Seeder;
use app\Model\Persontype;

class PersontypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new Persontype();
        $obj->persontype = 'CLIENTE';
        $obj->save();

        $obj = new Persontype();
        $obj->persontype = 'PROVEEDOR';
        $obj->save();
    }
}
