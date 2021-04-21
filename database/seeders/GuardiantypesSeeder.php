<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GuardiantypesSeeder extends Seeder
{
    private $seeds;

    public function __construct()
    {
        //instantiate $this->seeds with teacher data
        $this->seeds = $this->buildSeeds();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }

    private function buildSeeds()
    {
        return [
            [1,'mother',1,1],
            [2,'father',2,2],
            [3,'grandmother',1,3],
            [4,'grandfather',2,4],
            [5,'aunt',1,5],
            [6,'uncle',2,6],
            [7,'guardian_mother',1,7],
            [8,'guardian_father',2,8],
            [9,'step-mother',1,9],
            [10,'step-father',2,10],
            [11,'foster mother',1,11],
            [12,'foster father',2,12],
        ];

    }

}
