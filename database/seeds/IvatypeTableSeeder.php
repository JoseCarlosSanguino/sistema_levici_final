<?php

use Illuminate\Database\Seeder;
use app\Models\Ivatype;

class IvatypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new Ivatype();
        $obj->ivatype = 'Excento';
        $obj->percent = 0;
        $obj->save();

        $obj = new Ivatype();
        $obj->ivatype = '10,5%';
        $obj->percent = 10.5;
        $obj->save();

        $obj = new Ivatype();
        $obj->ivatype = '21%';
        $obj->percent = 21;
        $obj->save();

        $obj = new Ivatype();
        $obj->ivatype = '27%';
        $obj->percent = 27;
        $obj->save();

    }
}
