<?php

use Illuminate\Database\Seeder;
use App\Model\Producttype;

class ProducttypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new Producttype();
        $obj->producttype = 'PRODUCTO GENERAL';
        $obj->salable = 1;
        $obj->rentable = 1;
        $obj->save();
    }
}
