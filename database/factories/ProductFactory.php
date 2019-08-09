<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => 'Apple',
        'description' => 'Samsung is better',
        'category' => 1,
        'price' => 999
    ];
});
