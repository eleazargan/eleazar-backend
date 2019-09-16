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


$factory->define(App\Models\Project::class, function (Faker\Generator $faker) {
    return [
        'id' => Ramsey\Uuid\Uuid::uuid4()->toString(),
        'title' => $faker->sentence(),
        'description' => $faker->text(200),
        'repo_url' => $faker->url,
        'demo_url' => $faker->url,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});
