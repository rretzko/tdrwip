<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhonetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phonetypes')->insert([
            ['descr' => 'mobile',],
            ['descr' => 'work',],
            ['descr' => 'home',],
            ['descr' => 'phone_student_mobile'],
            ['descr' => 'phone_student_home'],
            ['descr' => 'phone_parent_mobile'],
            ['descr' => 'phone_parent_work'],
            ['descr' => 'phone_parent_home'],
        ]);
    }
}
