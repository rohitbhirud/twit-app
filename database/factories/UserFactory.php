<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'nickname' => $faker->firstName(),
        'email' => $faker->unique()->safeEmail,
        'twitter_id' => $faker->randomNumber(9, true),
        'avatar' => $faker->imageUrl(),
        'oauth_token' => str_random(),
        'oauth_token_secret' => str_random(),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
