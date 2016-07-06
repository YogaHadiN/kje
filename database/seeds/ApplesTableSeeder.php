<?php

use Illuminate\Database\Seeder;

class ApplesTableSeeder extends Seeder {

    public function run()
    {
        factory(App\Apple::class, 30)->create();
    }

}