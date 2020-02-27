<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Conference;
use Faker\Generator as Faker;

$factory->define(Conference::class, function (Faker $faker, $params) {
    return [
        'status' => $params['status'] ?? $faker->sentence(1),
        'translation_key' => $params['translation_key'] ?? $faker->sentence(1),
        'name_pl' => $params['name_pl'] ?? $faker->sentence(1),
        'name_en' => $params['name_en'] ?? $faker->sentence(1),
        'name_ru' => $params['name_ru'] ?? $faker->sentence(1)
    ];
});
