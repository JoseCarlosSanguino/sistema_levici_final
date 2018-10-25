<?php

use Illuminate\Database\Seeder;
use App\Model\Ivacondition;

class IvaconditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ivacond = new Ivacondition();
        $ivacond->ivacondition = 'Responsable inscripto';
        $ivacond->save();

        $ivacond = new Ivacondition();
        $ivacond->ivacondition = 'Excento';
        $ivacond->save();

        $ivacond = new Ivacondition();
        $ivacond->ivacondition = 'Monotributo';
        $ivacond->save();

        $ivacond = new Ivacondition();
        $ivacond->ivacondition = 'Consumidor final';
        $ivacond->save();
    }
}
