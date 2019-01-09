<?php

use Illuminate\Database\Seeder;
use app\Models\Provider;

class ProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Provider::class, 100000)->create()->each(function ($p) {
            factory(Provider::class)->make();
        });
    }

}
