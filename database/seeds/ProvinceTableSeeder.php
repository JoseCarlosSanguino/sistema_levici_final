<?php

use Illuminate\Database\Seeder;
use App\Model\Province;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province = new Province();
        $province->province = 'Mendoza';
        $province->save();

        $province = new Province();
        $province->province = 'San Juan';
        $province->save();
    }
}
