<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker, $params) {
    return [
        'login_email' => $params['login_email'] ?? $faker->unique()->safeEmail,
        'password' => $params['password'] ?? bcrypt('12345678'),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birthdate' => $faker->date('d/m/Y'),
        'gender' => $faker->randomElement([0, 1]),
        'contact_email' => $faker->unique()->email,
        'phone_number' => $faker->phoneNumber,
        'email_verified_at' => now(),
        'remember_token' => Str::random(10)
    ];
});
