<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductCategory;
use App\Product;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    return [
        'ProductCategory'   => $faker->realText(200),
        'ProductRef'        => Product::pluck('ProductRef')[$faker->numberBetween(1,Product::count()-1)],
        'EntryDate'         => $faker->date(),
    ];
});
