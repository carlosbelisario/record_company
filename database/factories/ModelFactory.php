<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Model\Album::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'published' => $faker->date('Y-m-d'),
    ];
});

$factory->define(App\Model\Artist::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Model\Roles::class, function (Faker\Generator $faker) {
    return [
        'rol' => $faker->name,
    ];
});


