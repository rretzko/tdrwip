<?php

namespace App\Models;

use App\Models\Registrant;
use App\Models\Score;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $with = ['adjudicators'];

    /**
     * Returns adjudicators by id, i.e. first assigned, second assigned, etc.
     * @return mixed
     */
    public function adjudicators()
    {
        return $this->hasMany(\App\Models\Adjudicator::class)
            ->orderBy('rank');
    }

    public function alphaNameSortedAdjudicators()
    {
        return $this->adjudicators->sortBy('user.person.last');
    }

    public function filecontenttypes()
    {
        return $this->belongsToMany(Filecontenttype::class);
    }

    public function getAdjudicatedCountAttribute()
    {
        return __LINE__;
    }

    public function instrumentations()
    {
        return $this->belongsToMany(Instrumentation::class);
    }

    public function logNoShow(Registrant $registrant): void
    {
        foreach($this->adjudicators AS $adjudicator){

            foreach($this->filecontenttypes AS $filecontenttype){

                foreach($filecontenttype->scoringcomponents AS $scoringcomponent){

                    Score::updateOrCreate(
                        [
                            'registrant_id' => $registrant->id,
                            'eventversion_id' => $this->eventversion_id,
                            'user_id' => $adjudicator->user_id,
                            'scoringcomponent_id' => $scoringcomponent->id,
                        ],
                        [
                            'score' => 0,
                            'proxy_id', $adjudicator->user_id,
                        ]
                    );

                    Scoresummary::updateOrCreate(
                      [
                          'eventversion_id' => $this->eventversion_id,
                          'registrant_id' => $registrant->id,
                          'instrumentation_id' => $registrant->instrumentations->first()->id,
                      ] ,
                      [
                          'score_total' => Score::where('registrant_id',$registrant->id)->sum('score'),
                          'score_count' => Score::where('registrant_id',$registrant->id)->count('score'),
                          'result' => 'ns',
                      ]
                    );
                }
            }
        }
    }
}
