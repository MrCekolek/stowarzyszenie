<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(RoleUser::class, function (Faker $faker, $params) {
    return [
        'role_id' => $params['role_id'] ?? factory(Role::class)->create()->id,
        'user_id' => $params['user_id'] ?? factory(User::class)->create()->id
    ];
});
