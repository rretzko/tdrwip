<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShirtsizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gradetypes')->insert([
                ['descr' => 'medium', 'abbr' => 'M', 'orderby' => 4],
                ['descr' => 'double extra small', 'abbr' => 'XXS', 'orderby' => 1],
                ['descr' => 'extra small', 'abbr' => 'XS', 'orderby' => 2],
                ['descr' => 'small', 'abbr' => 'S', 'orderby' => 3],
                ['descr' => 'large', 'abbr' => 'L', 'orderby' => 5],
                ['descr' => 'extra large', 'abbr' => 'XL', 'orderby' => 6],
                ['descr' => 'double extra large', 'abbr' => 'XXL', 'orderby' => 7],
            ]);
    }
}
