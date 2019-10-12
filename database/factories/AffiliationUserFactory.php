<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\AffiliationUser;
use Faker\Generator as Faker;

$factory->define(AffiliationUser::class, function (Faker $faker, $params) {
    return [
        'title' => $faker->title,
        'institution' => $faker->sentence(3),
        'department' => $faker->sentence(3),
        'street' => $faker->streetName,
        'city' => $faker->city,
        'country' => $faker->country,
        'user_id' => $params['user_id'] ?? factory(User::class)->create()->id
    ];
});
