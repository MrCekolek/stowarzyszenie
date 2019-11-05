<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Permission;
use App\Models\PermissionParent;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker, $params) {
    return [
        'name' => $faker->sentence(1),
        'translation_key' => $faker->sentence(1),
        'permission_parent_id' => $params['permission_parent_id'] ?? factory(PermissionParent::class)->create()->id
    ];
});
