<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HomeNavigation;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(HomeNavigation::class, function (Faker $faker, $params) {
    return [
        'status' => $params['status'] ?? $faker->sentence(1),
        'name_pl' => $params['name_pl'] ?? $faker->sentence(1),
        'name_en' => $params['name_en'] ?? $faker->sentence(1),
        'name_ru' => $params['name_ru'] ?? $faker->sentence(1),
        'link' => $params['link'] ?? $faker->url,
        'content_pl' => $params['content_pl'] ?? $faker->sentence(1),
        'content_en' => $params['content_en'] ?? $faker->sentence(1),
        'content_ru' => $params['content_ru'] ?? $faker->sentence(1),
        'user_id' => $params['user_id'] ?? factory(User::class)->create()->id
    ];
});
