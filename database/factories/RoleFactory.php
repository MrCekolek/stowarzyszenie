<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker, $params) {
    return [
        'name_pl' => $params['name_pl'] ?? $faker->sentence(1),
        'name_en' => $params['name_en'] ?? $faker->sentence(1),
        'name_ru' => $params['name_ru'] ?? $faker->sentence(1)
    ];
});
