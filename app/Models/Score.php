<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $with = ['scoringcomponent'];
    private $eventversion;

    protected $fillable = ['eventversion_id', 'scoringcomponent_id', 'multiplier', 'proxy_id', 'registrant_id','score', 'user_id'];

    public function registrantScores(\App\Models\Registrant $registrant)
    {
        $this->eventversion = Eventversion::find($registrant->eventversion_id);

        $scores = $this->where('registrant_id', $registrant->id)
            ->select('score', 'scoringcomponent_id')
            ->orderBy('user_id')
            ->orderBy('scoringcomponent_id')
            ->get()
            ->toArray();

        return $this->mapScores($scores);
    }

    public function scoringcomponent()
    {
        return $this->belongsTo(Scoringcomponent::class,'scoringcomponent_id','id');
    }

    public function mapScores($scores)
    {
        //NJ All-State Chorus; 2022
        foreach($scores AS $score){

            $scoringcomponents[$score['scoringcomponent_id']][] = $score['score'];
        }

        if($scores) {

            switch ($this->eventversion->event->id) {
                case 1: //CJMEA

                    $scores =
                        [
                            $scoringcomponents[75][0], //scales quality
                            $scoringcomponents[76][0], //scales diatonic intonation
                            $scoringcomponents[77][0], //scales chromatic intonation
                            $scoringcomponents[78][0], //solo quality
                            $scoringcomponents[79][0], //solo intonation
                            $scoringcomponents[80][0], //solo musicianship
                            $scoringcomponents[81][0], //swan quality
                            $scoringcomponents[82][0], //swan intonation
                            $scoringcomponents[83][0], //swan musicianship

                            $scoringcomponents[75][1],
                            $scoringcomponents[76][1],
                            $scoringcomponents[77][1],
                            $scoringcomponents[78][1],
                            $scoringcomponents[79][1],
                            $scoringcomponents[80][1],
                            $scoringcomponents[81][1],
                            $scoringcomponents[82][1],
                            $scoringcomponents[83][1],
                        ];
                    break;
                case 19: //All-Shore

                    if (isset($scoringcomponents)) {
                        $scores = [
                            //All-Shore 2022-23
                            $scoringcomponents[64][0], //low scale
                            $scoringcomponents[65][0], //high scale
                            $scoringcomponents[66][0], //chromatic scale
                            $scoringcomponents[67][0], //arpeggio
                            $scoringcomponents[69][0], //quartet
                            $scoringcomponents[68][0], //solo

                            $scoringcomponents[64][1],
                            $scoringcomponents[65][1],
                            $scoringcomponents[66][1],
                            $scoringcomponents[67][1],
                            $scoringcomponents[69][1],
                            $scoringcomponents[68][1],

                            $scoringcomponents[64][2],
                            $scoringcomponents[65][2],
                            $scoringcomponents[66][2],
                            $scoringcomponents[67][2],
                            $scoringcomponents[69][2],
                            $scoringcomponents[68][2],
                        ];
                    } else {

                        $scores = [
                            0, 0, 0, 0, 0, 0,
                            0, 0, 0, 0, 0, 0,
                            0, 0, 0, 0, 0, 0,
                        ];
                    }
                    break;
                case 25: //MAHC
                    $scores = [
                        //MAHC 2022-23
                        $scoringcomponents[70][0], //low scale quality
                        $scoringcomponents[71][0], //low scale intonation
                        $scoringcomponents[72][0], //high scale quality
                        $scoringcomponents[73][0], //high scale intonation
                        $scoringcomponents[94][0], //solo quality
                        $scoringcomponents[95][0], //solo intonation
                        $scoringcomponents[96][0], //solo musicianship

                        $scoringcomponents[70][1], //...
                        $scoringcomponents[71][1],
                        $scoringcomponents[72][1],
                        $scoringcomponents[73][1],
                        $scoringcomponents[94][1],
                        $scoringcomponents[95][1],
                        $scoringcomponents[96][1],

                        $scoringcomponents[70][2],
                        $scoringcomponents[71][2],
                        $scoringcomponents[72][2],
                        $scoringcomponents[73][2],
                        $scoringcomponents[94][2],
                        $scoringcomponents[95][2],
                        $scoringcomponents[96][2],
                    ];
                    break;
                default: //NJ All-State
                    if($this->eventversion->id == 71) {

                        $scores = [
                            $scoringcomponents[48][0], //judge 1, Scales Quality
                            $scoringcomponents[49][0], //judge 1, Scales Low Scales
                            $scoringcomponents[50][0], //judge 1, Scales High Scales
                            $scoringcomponents[51][0], //judge 1, Scales Chromatic Scales
                            $scoringcomponents[58][0], //judge 1, Solo Quality
                            $scoringcomponents[59][0], //judge 1, Solo Intonation
                            $scoringcomponents[60][0], //judge 1, Solo Musicianship
                            $scoringcomponents[61][0], //judge 1, Quintet Quality
                            $scoringcomponents[62][0], //judge 1, Quintet Intonation
                            $scoringcomponents[63][0], //judge 1, Quintet Musicianship

                            $scoringcomponents[48][1], //judge 2, Scales Quality
                            $scoringcomponents[49][1], // etc.
                            $scoringcomponents[50][1],
                            $scoringcomponents[51][1],
                            $scoringcomponents[58][1],
                            $scoringcomponents[59][1],
                            $scoringcomponents[60][1],
                            $scoringcomponents[61][1],
                            $scoringcomponents[62][1],
                            $scoringcomponents[63][1],

                            $scoringcomponents[48][2],
                            $scoringcomponents[49][2],
                            $scoringcomponents[50][2],
                            $scoringcomponents[51][2],
                            $scoringcomponents[58][2],
                            $scoringcomponents[59][2],
                            $scoringcomponents[60][2],
                            $scoringcomponents[61][2],
                            $scoringcomponents[62][2],
                            $scoringcomponents[63][2],
                        ];
                    }

                    if($this->eventversion->id == 75) {

                        $scores = [
                            $scoringcomponents[84][0], //judge 1, Scales Quality
                            $scoringcomponents[85][0], //judge 1, Scales Low Scales
                            $scoringcomponents[86][0], //judge 1, Scales High Scales
                            $scoringcomponents[87][0], //judge 1, Scales Chromatic Scales
                            $scoringcomponents[88][0], //judge 1, Solo Quality
                            $scoringcomponents[89][0], //judge 1, Solo Intonation
                            $scoringcomponents[90][0], //judge 1, Solo Musicianship
                            $scoringcomponents[91][0], //judge 1, Quintet Quality
                            $scoringcomponents[92][0], //judge 1, Quintet Intonation
                            $scoringcomponents[93][0], //judge 1, Quintet Musicianship

                            $scoringcomponents[84][1], //judge 2, Scales Quality
                            $scoringcomponents[85][1], // etc.
                            $scoringcomponents[86][1],
                            $scoringcomponents[87][1],
                            $scoringcomponents[88][1],
                            $scoringcomponents[89][1],
                            $scoringcomponents[90][1],
                            $scoringcomponents[91][1],
                            $scoringcomponents[92][1],
                            $scoringcomponents[93][1],

                            $scoringcomponents[84][2],
                            $scoringcomponents[85][2],
                            $scoringcomponents[86][2],
                            $scoringcomponents[87][2],
                            $scoringcomponents[88][2],
                            $scoringcomponents[89][2],
                            $scoringcomponents[90][2],
                            $scoringcomponents[91][2],
                            $scoringcomponents[92][2],
                            $scoringcomponents[93][2],
                        ];
                    }

            }
        }else{ //no show
            //hard-coded for cjmes
            $scores = array_fill(0,18,0);
        }

        return $scores;
    }

}
