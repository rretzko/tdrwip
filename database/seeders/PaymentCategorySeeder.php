<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
          1 => 'registration',
          2 => 'participation',
          3 => 'housing',
          4 => 'other',
        ];
    }
}
