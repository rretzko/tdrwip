<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrarymediatypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('librarymediatypes')->insert([
            ['descr' => 'sheet music', 'order_by' => 1],
            ['descr' => 'compilation', 'order_by' => 2],
            ['descr' => 'CD', 'order_by' => 3],
            ['descr' => 'vinyl', 'order_by' => 4],
            ['descr' => 'DVD', 'order_by' => 5],
            ['descr' => 'cassette', 'order_by' => 6],
        ]); 
    }
}
