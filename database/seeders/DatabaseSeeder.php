<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Subscriberemail;
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
         $this->call(HonorificsSeeder::class);
         $this->call(PronounsSeeder::class);
         $this->call(SearchtypeSeeder::class);
         $this->call(EmailtypeSeeder::class);
         $this->call(PhonetypeSeeder::class);
         $this->call(GeostateSeeder::class);
         $this->call(RoletypeSeeder::class);
         $this->call(GradetypeSeeder::class);
         $this->call(StudenttypeSeeder::class);
         $this->call(ShirtsizeSeeder::class);
         //User::factory(100)->create();
         //Person::factory(20)->create();
         //Subscriberemail::factory(20)->create();
    }
}
