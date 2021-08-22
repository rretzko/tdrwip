<?php

namespace Database\Seeders;

use App\Models\Pitchfile;
use Illuminate\Database\Seeder;

class PitchfilesSeeder extends Seeder
{
    private $seeds;

    public function __construct()
    {
        $this->seeds = $this->buildSeeds();
    }

    private function buildSeeds()
    {
        return [
            [
                'eventversion_id' => 65,
                'filecontenttype_id' => 1,
                'instrumentation_id' => 63,
                'location' => '/assets/pitchfiles/9/65/scales/si/assets/pitchfiles/9/65/scales/si/soprano_i-scales-high-scale.mp3',
                'descr' => 'High Scale'
            ],
            [
                'eventversion_id' => 65,
                'filecontenttype_id' => 1,
                'instrumentation_id' => 63,
                'location' => '/assets/pitchfiles/9/65/scales/si/assets/pitchfiles/9/65/scales/si/soprano_i-scales-low-scale.mp3',
                'descr' => 'Low Scale'
            ],
            [
                'eventversion_id' => 65,
                'filecontenttype_id' => 1,
                'instrumentation_id' => 63,
                'location' => '/assets/pitchfiles/9/65/scales/si/soprano_i-scales-chromatic-scale.mp3',
                'descr' => 'Chromatic Scale'
            ],
            [
                'eventversion_id' => 65,
                'filecontenttype_id' => 1,
                'instrumentation_id' => NULL,
                'location' => '/assets/pitchfiles/9/65/quintet/all/all-quintet-full-ensemble.mp3',
                'descr' => 'Full Ensemble'
            ],
            [
                'eventversion_id' => 65,
                'filecontenttype_id' => 1,
                'instrumentation_id' => NULL,
                'location' => '/assets/pitchfiles/9/65/quintet/all/all-quintet-sheet-music.pdf',
                'descr' => 'Sheet music'
            ],




        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->seeds AS $seed)
        {
            Pitchfile::create([
               'eventversion_id' => $seed['eventversion_id'],
               'filecontenttype_id' => $seed['filecontenttype_id'],
               'instrumentation_id' => $seed['instrumentation_id'],
               'location' => $seed['location'],
               'descr' => $seed['descr'],
            ]);
        }
    }
}
