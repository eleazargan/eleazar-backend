<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Article::class, 100)->create();
        factory(App\Models\Project::class, 100)->create();
    }
}
