<?php

use Faker\Generator as Faker;
use app\Model\Customer;


$factory->define(Customer::class, function (Faker $faker) {
    return [
        'ivacondition_id'   => rand(1,4),
        'province_id'       => 1,
        'city_id'           => 1,
        'cuit'              => rand(20000000000,90000000000),
        'provider'          => $faker->name,
        'address'           => $faker->address,
        'markup'            => rand(-30,40),
    ];
});