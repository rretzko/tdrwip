<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Teacher::all() AS $teacher){
            $user_id = $teacher->user_id;
            if($user_id != 45) {
                Membership::updateOrCreate([
                    'user_id' => $user_id,
                    'organization_id' => 4, //NAfME
                    'membershiptype_id' => 1,
                    'membership_id' => 'unknown',
                    'expiration' => '2021-08-05',
                    'grade_levels' => 'Secondary',
                    'subjects' => 'Chorus',
                ]);

                Membership::create([
                    'user_id' => $user_id,
                    'organization_id' => 11, //Eastern Division
                    'membershiptype_id' => 1,
                    'membership_id' => 'unknown',
                    'expiration' => '2021-08-05',
                    'grade_levels' => 'Secondary',
                    'subjects' => 'Chorus',
                ]);

                Membership::create([
                    'user_id' => $user_id,
                    'organization_id' => 3, //NJMEA
                    'membershiptype_id' => 1,
                    'membership_id' => 'unknown',
                    'expiration' => '2021-08-05',
                    'grade_levels' => 'Secondary',
                    'subjects' => 'Chorus',
                ]);
            }
        }
    }
}
