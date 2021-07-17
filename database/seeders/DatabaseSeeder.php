<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Subscriberemail;
use App\Models\User;
use Database\Factories\PersonFactory;
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
         $this->call(GuardiantypeSeeder::class);
         $this->call(StudenttypeSeeder::class);
         $this->call(ShirtsizeSeeder::class);
         $this->call(SchoolSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(TeacherSeeder::class);
         $this->call(SubscriberEmailSeeder::class);
         $this->call(PhoneSeeder::class);
         $this->call(StudentSeeder::class);
         $this->call(NonsubscriberEmailSeeder::class);
         $this->call(InstrumentationbranchSeeder::class);
         $this->call(InstrumentationSeeder::class);
         $this->call(InstrumentationUserSeeder::class);
         $this->call(AddressSeeder::class);
         $this->call(GuardianSeeder::class);
         $this->call(SchoolyearSeeder::class);
         $this->call(EnsembleSeeder::class);
         $this->call(EnsembletypeSeeder::class);
         $this->call(EnsembletypeInstrumentationSeeder::class);
         $this->call(AssetSeeder::class);
         $this->call(EnsembleassetSeeder::class);
         $this->call(PublisherSeeder::class);
    }
}
