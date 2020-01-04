<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Portfolio;
use App\Models\PortfolioTab;
use Faker\Generator as Faker;

$factory->define(PortfolioTab::class, function (Faker $faker, $params) {
    return [
        'shared_id' => $params['shared_id'] ?? $faker->randomNumber(3),
        'name_en' => $params['name_en'] ?? $faker->sentence(1),
        'name_pl' => $params['name_pl'] ?? $faker->sentence(1),
        'name_ru' => $params['name_ru'] ?? $faker->sentence(1),
        'admin_visibility' => $params['admin_visibility'] ?? 1,
        'user_visibility' => $params['user_visibility'] ?? 1,
        'portfolio_id' => $params['portfolio_id'] ?? factory(Portfolio::create()->id)
    ];
});
