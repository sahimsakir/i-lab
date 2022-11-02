<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, static function (Faker $faker) {
    return [
        'staff_id' => uniqid(null, false),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => Str::slug(uniqid(null, true), '_').$faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'cell_number' => $faker->tollFreePhoneNumber,
        'designation' => $faker->sentence(2, false),
        'team' => $faker->randomElement(['Dummy Dhaka Region', 'Dummy Chittagong Region', 'Dummy Khulna Region',]),
        'tnc_accepted' => true,
        'tnc_accepted_at' => Carbon::now(),
        'two_factor_auth_token' => Str::random(8),
        'two_factor_auth_expiry' => Carbon::now()->addDays(3),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(),
    ];
});
