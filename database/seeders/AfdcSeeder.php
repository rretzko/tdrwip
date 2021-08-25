<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AfdcSeeder extends Seeder
{
    private $dtseeds;

    public function __construct()
    {
        $this->dtseeds = $this->buildDateSeeds();
    }

    private function buildDateSeeds()
    {
        return [
            66 => [ //NJ ALL-STATE CHORUS
                1 => '2021-08-25 08:51:19', //admin_open
                2 => '', //admin_close
                3 => '2021-08-25 08:51:19', //membership_open
                4 => '', //membership_close
                5 => '', //student_open
                6 => '', //student_close
                7 => '2021-08-25 08:51:19', //voice_change_open
                8 => '', //voice_change_close
                9 => '2021-08-25 08:51:19', //signature_open
                10 => '', //signature_close
                11 => '', //score_open
                12 => '', //score_close
                13 => '', //tab_close
                14 => '', //results_release
                15 => '2021-08-25 08:51:19', //applications_open
                16 => '', //applications_close
                17 => '2021-08-25 08:51:19', //videos_membership_open
                18 => '', //videos_membership_close
                19 => '', //videos_student_open
                20 => '', //videos_student_close
                21 => '', //membership_valid
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runEventversions();

        $this->runEventversionconfigs();

        $this->runEventversionensembles();

        $this->runEventversiondates();

    }

    private function runEventversions()
    {
        DB::table('eventversions')
            ->insert([
                'event_id' => 12,
                'name' => '64th Annual Senior High Chorus',
                'short_name' => 'SJCDA Sr. High',
                'senior_class_of' => 2022,
                'eventversiontype_id' => '21',
                'grades' => '10,11,12',
                'created_at' => '2021-08-25 07:53:54',
                'updated_at' => '2021-08-25 07:53:54',
            ]);

        DB::table('eventversions')
            ->insert([
                'event_id' => 11,
                'name' => '60th Annual Junior High Chorus',
                'short_name' => 'SJCDA Jr. High',
                'senior_class_of' => 2022,
                'eventversiontype_id' => '21',
                'grades' => '7,8,9',
                'created_at' => '2021-08-25 07:53:54',
                'updated_at' => '2021-08-25 07:53:54',
            ]);

        DB::table('eventversions')
            ->insert([
                'event_id' => 11,
                'name' => '2021-22 Elementary Chorus',
                'short_name' => 'SJCDA Elementary',
                'senior_class_of' => 2022,
                'eventversiontype_id' => '21',
                'grades' => '4,5,6',
                'created_at' => '2021-08-25 07:53:54',
                'updated_at' => '2021-08-25 07:53:54',
            ]);

        DB::table('eventversions')
            ->insert([
                'event_id' => 19,
                'name' => '2022 New Jersey All-Shore Chorus',
                'short_name' => '2022 All-Shore',
                'senior_class_of' => 2022,
                'eventversiontype_id' => '21',
                'grades' => '9,10,11,12',
                'created_at' => '2021-08-25 07:53:54',
                'updated_at' => '2021-08-25 07:53:54',
            ]);
    }

    private function runEventversionconfigs()
    {
        //SJCDA SENIOR
        DB::table('eventversionconfigs')
            ->insert([
                'eventversion_id' => 66,
                'paypalteacher' => 1,
                'paypalstudent' => 1,
                'registrationfee' => '25.00',
                'grades' => '10,11,12',
                'eapplication' => 0,
                'judge_count' => 3,
                'max_count' => 30,
                'max-uppervoice_count' => 0,
                'missing_judge_average' => 1,
                'epaymentsurcharge' => 0,
                'virtualaudition' => 1,
                'audiofiles' => 1,
                'videofiles' => 0,
                'bestscore' => 'asc',
                'membershipcard' => 1,
                'instrumentation_count' => 1,
                'created_at' => '2021-08-25 08:21:17',
                'updated_at' => '2021-08-25 08:21:17',
            ]);

        //SJCDA JUNIOR
        DB::table('eventversionconfigs')
            ->insert([
                'eventversion_id' => 67,
                'paypalteacher' => 1,
                'paypalstudent' => 1,
                'registrationfee' => '25.00',
                'grades' => '7,8,9',
                'eapplication' => 0,
                'judge_count' => 3,
                'max_count' => 30,
                'max-uppervoice_count' => 0,
                'missing_judge_average' => 1,
                'epaymentsurcharge' => 0,
                'virtualaudition' => 1,
                'audiofiles' => 1,
                'videofiles' => 0,
                'bestscore' => 'asc',
                'membershipcard' => 1,
                'instrumentation_count' => 1,
                'created_at' => '2021-08-25 08:21:17',
                'updated_at' => '2021-08-25 08:21:17',
            ]);

        //SJCDA ELEMENTARY
        DB::table('eventversionconfigs')
            ->insert([
                'eventversion_id' => 68,
                'paypalteacher' => 1,
                'paypalstudent' => 0,
                'registrationfee' => '25.00',
                'grades' => '4,5,6',
                'eapplication' => 0,
                'judge_count' => 0,
                'max_count' => 5,
                'max-uppervoice_count' => 0,
                'missing_judge_average' => 0,
                'epaymentsurcharge' => 0,
                'virtualaudition' => 0,
                'audiofiles' => 0,
                'videofiles' => 0,
                'bestscore' => 'asc',
                'membershipcard' => 1,
                'instrumentation_count' => 1,
                'created_at' => '2021-08-25 08:21:17',
                'updated_at' => '2021-08-25 08:21:17',
            ]);

        //ALL-SHORE
        DB::table('eventversionconfigs')
            ->insert([
                'eventversion_id' => 69,
                'paypalteacher' => 1,
                'paypalstudent' => 1,
                'registrationfee' => '15.00',
                'grades' => '9,10,11,12',
                'eapplication' => 1,
                'judge_count' => 3,
                'max_count' => 30,
                'max-uppervoice_count' => 0,
                'missing_judge_average' => 1,
                'epaymentsurcharge' => 1,
                'virtualaudition' => 1,
                'audiofiles' => 1,
                'videofiles' => 0,
                'bestscore' => 'desc',
                'membershipcard' => 0,
                'instrumentation_count' => 1,
                'created_at' => '2021-08-25 08:21:17',
                'updated_at' => '2021-08-25 08:21:17',
            ]);
    }

    private function runEventversionensembles()
    {
        //SJCDA SENIOR
        DB::table('eventensemble_eventversion')
            ->insert([
                'eventensemble_id' => 3,
                'eventversion_id' => 66,
                'created_at' => '2021-08-25 08:32:27',
                'updated_at' => '2021-08-25 08:32:27',
            ]);

        //SJCDA JUNIOR
        DB::table('eventensemble_eventversion')
            ->insert([
                'eventensemble_id' => 2,
                'eventversion_id' => 67,
                'created_at' => '2021-08-25 08:32:27',
                'updated_at' => '2021-08-25 08:32:27',
            ]);

        //SJCDA ELEMENTARY
        DB::table('eventensemble_eventversion')
            ->insert([
                'eventensemble_id' => 1,
                'eventversion_id' => 68,
                'created_at' => '2021-08-25 08:32:27',
                'updated_at' => '2021-08-25 08:32:27',
            ]);

        //ALL-SHORE
        DB::table('eventensemble_eventversion')
            ->insert([
                'eventensemble_id' => 5,
                'eventversion_id' => 69,
                'created_at' => '2021-08-25 08:32:27',
                'updated_at' => '2021-08-25 08:32:27',
            ]);
    }

    private function runEventversiondates()
    {
        foreach($this->dtseeds AS $seed) {
            foreach ($seed as $eventversion_id => $dt){
                DB::table('eventversiondates')
                    ->insert([
                        'eventversion_id' => $eventversion_id,
                        'datetype_id' => $dt[0],
                        'dt' => $dt[1],
                        'created_at' => '2021-08-25 08:41:33',
                        'updated_at' => '2021-08-25 08:41:33',
                    ]);
            }
        }
    }
}
