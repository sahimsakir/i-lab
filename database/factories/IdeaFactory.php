<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Idea;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Idea::class, static function (Faker $faker) {
    $dateS = Carbon::now()->startOfMonth()->subMonths(6);
    $dateE = Carbon::now()->startOfMonth();

    return [
        'user_id' => function () {
            return User::all()->random();
        },
        'is_active' => random_int(0, 1),
        'is_submitted' => random_int(0, 1),
        'submitted_at' => $faker->randomElement([$dateS, $dateE]),
        'is_approved' => random_int(0, 1),
        'is_featured' => random_int(0, 1),
        'topic' => $faker->randomElement(
            [
                'Distribution', 'Consumer Engagement', 'B2B', 'Automation', 'Merchandising', 'FF', 'Research', 'Channel Management', 'Product',
                'Pricing and Compliance', 'Sales Management', 'Illicit', 'New Category', 'Alternative Revenue', 'Culture and Way of Work', 'Others',
            ]
        ),
        'title' => $faker->sentence(5),
        'elevator_pitch' => $faker->sentence(100, true),
        'description' => $faker->sentence(200, true),
        'created_at' => Carbon::now()->subDays(random_int(1, 365)),
        'updated_at' => Carbon::now()->subDays(random_int(1, 365)),
    ];
});