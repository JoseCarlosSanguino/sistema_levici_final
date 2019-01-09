<?php

use Illuminate\Database\Seeder;
use app\Models\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Customer::class, 100000)->create()->each(function ($p) {
            factory(Customer::class)->make();
        });
    }

}
