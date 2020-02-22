<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PermissionParent;
use Faker\Generator as Faker;

$factory->define(PermissionParent::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(1),
        'translation_key' => $faker->sentence(2)
    ];
});
