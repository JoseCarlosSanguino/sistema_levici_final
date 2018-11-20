<?php

use Illuminate\Database\Seeder;
use app\Model\Provider;

class ProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Provider::class, 10)->create()->each(function ($p) {
            factory(Provider::class)->make();
        });
    }

}
