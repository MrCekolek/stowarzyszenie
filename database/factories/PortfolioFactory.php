<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Portfolio;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Portfolio::class, function (Faker $faker, $params) {
    return [
        'user_id' => $params['user_id'] ?? factory(User::create()->id)
    ];
});
