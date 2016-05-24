<?php

use Illuminate\Database\Seeder;

class AppleTypesTableSeeder extends Seeder {

    public function run()
    {
        factory(App\AppleType::class, 30)->create();
    }

}