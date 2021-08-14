<?php

namespace Database\Seeders;

use App\Models\Eventversionconfig;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventversionconfigSeeder extends Seeder
{
    private $seeds;

    public function __construct()
    {
        $this->seeds = $this->buildSeeds();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->seeds AS $seed){
            Eventversionconfig::create([
                'eventversion_id' => $seed['eventversion_id'],
                'paypalteacher' => $seed['paypalteacher'],
                'paypalstudent' => $seed['paypalstudent'],
                'registrationfee' => $seed['registrationfee'],
                'grades' => $seed['grades'],
                'eapplication' => $seed['eapplication'],
                'judge_count' => $seed['judge_count'],
                'missing_judge_average' => $seed['missing_judge_average'],
                'epaymentsurcharge' => $seed['epaymentsurcharge'],
                'bestscore' => $seed['bestscore'],
                'membershipcard' => $seed['membershipcard'],
                'virtualaudition' => $seed['virtualaudition'],
            ]);
        }
    }

    private function buildSeeds()
    {
        return [
            [
                'eventversion_id' => 61,
                'paypalteacher' => 1,
                'paypalstudent' => 1,
                'registrationfee' => 16,
                'grades' => '9,10,11,12',
                'eapplication' => 1,
                'judge_count' => 3,
                'missing_judge_average' => 1,
                'epaymentsurcharge' => 1,
                'bestscore' => 'desc',
                'membershipcard' => 0,
                'virtualaudition' => 0,
            ],
            [
                'eventversion_id' => 62,
                'paypalteacher' => 1,
                'paypalstudent' => 1,
                'registrationfee' => 10,
                'grades' => '4,5,6',
                'eapplication' => 0,
                'judge_count' => 0,
                'missing_judge_average' => 1,
                'epaymentsurcharge' => 0,
                'bestscore' => 'desc',
                'membershipcard' => 1,
                'virtualaudition' => 0,
            ],
            [
                'eventversion_id' => 63,
                'paypalteacher' => 1,
                'paypalstudent' => 1,
                'registrationfee' => 15,
                'grades' => '7,8,9',
                'eapplication' => 0,
                'judge_count' => 0,
                'missing_judge_average' => 1,
                'epaymentsurcharge' => 0,
                'bestscore' => 'desc',
                'membershipcard' => 2,
                'virtualaudition' => 0,
            ],
            [
                'eventversion_id' => 64,
                'paypalteacher' => 1,
                'paypalstudent' => 1,
                'registrationfee' => 15,
                'grades' => '7,8,9',
                'eapplication' => 0,
                'judge_count' => 0,
                'missing_judge_average' => 1,
                'epaymentsurcharge' => 0,
                'bestscore' => 'desc',
                'membershipcard' => 1,
                'virtualaudition' => 0,
            ],
            [
                'eventversion_id' => 65,
                'paypalteacher' => 1,
                'paypalstudent' => 1,
                'registrationfee' => 25,
                'grades' => '10,11,12',
                'eapplication' => 0,
                'judge_count' => 3,
                'missing_judge_average' => 1,
                'epaymentsurcharge' => 0,
                'bestscore' => 'asc',
                'membershipcard' => 1,
                'virtualaudition' => 1,
            ],

        ];
    }
}
