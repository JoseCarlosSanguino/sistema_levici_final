<?php

use Faker\Generator as Faker;
use app\Model\Provider;


$factory->define(Provider::class, function (Faker $faker) {
    return [
        'ivacondition_id'   => rand(1,4),
        'province_id'       => 1,
        'city_id'           => 1,
        'cuit'              => rand(20000000000,90000000000),
        'name'              => $faker->name,
        'address'           => $faker->address,
        'markup'            => rand(10,120),
    ];
});