<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\PreferenceUser;
use Faker\Generator as Faker;

$factory->define(PreferenceUser::class, function (Faker $faker, $params) {
    return [
        'avatar' => $faker->randomElement(['../../../../assets/images/default_man.png', '../../../../assets/images/default_woman.png']),
        'time_zone' => 'Europe/Warsaw',
        'lang' => 'en',
        'user_id' => $params['user_id'] ?? factory(User::class)->create()->id
    ];
});
