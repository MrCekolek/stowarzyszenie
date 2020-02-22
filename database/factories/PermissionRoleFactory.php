<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(PermissionRole::class, function (Faker $faker, $params) {
    return [
        'permission_id' => $params['permission_id'] ?? factory(Permission::class)->create()->id,
        'role_id' => $params['role_id'] ?? factory(Role::class)->create()->id,
        'selected' => 1
    ];
});
