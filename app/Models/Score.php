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

        switch($this->eventversion->event->id){
            case 1: //CJMEA
                $scores =
                    [

                    ];
                break;
            case 19: //All-Shore
                $scores =
                    [

                    ];
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

        return $scores;
    }

}
