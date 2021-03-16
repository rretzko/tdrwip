<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gradetypes')->insert([
            ['descr' => '1'],
            ['descr' => '2'],
            ['descr' => '3'],
            ['descr' => '4'],
            ['descr' => '5'],
            ['descr' => '6'],
            ['descr' => '7'],
            ['descr' => '8'],
            ['descr' => '9'],
            ['descr' => '10'],
            ['descr' => '11'],
            ['descr' => '12'],
            ['descr' => 'collegiate'],
            ['descr' => 'adult'],
        ]);
    }
}
