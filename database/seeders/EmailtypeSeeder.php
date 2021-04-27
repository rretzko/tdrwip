<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emailtypes')->insert([
            ['descr' => 'work',],
            ['descr' => 'personal',],
            ['descr' => 'other',],
            ['descr' => 'email_student_school'],
            ['descr' => 'email_student_personal'],
            ['descr' => 'email_guardian_alternate'],
            ['descr' => 'email_guardian_primary'],
        ]);
    }
}
