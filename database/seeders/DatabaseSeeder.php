<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(100)->create();
         Person::factory(20)->create();
         $this->call(HonorificsSeeder::class);
         $this->call(PronounsSeeder::class);
    }
}
