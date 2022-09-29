<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cunam;

class CunamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cunam::create([
            'cunam'=>'Sebelum Makan'
        ]);
        Cunam::create([
            'cunam'=>'Sesudah Makan'
        ]);
        Cunam::create([
            'cunam'=> 'Diantara Makan'
        ]);
        Cunam::create([
            'cunam'=> 'Tidak tergantung makan'
        ]);
    }
}
