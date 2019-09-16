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


$factory->define(App\Models\Article::class, function (Faker\Generator $faker) {
    return [
        'id' => Ramsey\Uuid\Uuid::uuid4()->toString(),
        'title' => $faker->sentence(),
        'description' => $faker->text(200),
        'content' => $faker->text(500),
        'tags' => $faker->words(4),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});
