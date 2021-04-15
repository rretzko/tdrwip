<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoletypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roletypes')->insert([
            ['descr' => 'subscriber',],
            ['descr' => 'customer',],
            ['descr' => 'patron'],
            ['descr' => 'student'],
            ['descr' => 'event_administrator'],
            ['descr' => 'registration_manager'],
            ['descr' => 'rehearsal_manager'],
            ['descr' => 'conductor'],
            ['descr' => 'judge'],
            ['descr' => 'monitor'],
            ['descr' => 'judge_monitor'],
            ['descr' => 'guest'],
            ['descr' => 'other'],
            ['descr' => 'persona_non_grata'],
            ['descr' => 'teacher'],
            ['descr' => 'domainowner'],
        ]);
    }
}
