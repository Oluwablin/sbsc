<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\ProductCategory;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'Product'           => $faker->realText(200),
        'CategoryID'        => ProductCategory::pluck('ProductCategoryRef')[$faker->numberBetween(1,ProductCategory::count()-1)],
        'Quantity'          => $faker->randomDigit,
        'Amount'            => $faker->randomFloat(2, 10, 100),
        'EntryDate'         => $faker->date(),
        'ExpiryDate'        => $faker->date(),
        'ProductImage'      => $faker->image,
    ];
});
