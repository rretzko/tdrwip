<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $with = ['scoringcomponent'];

    protected $fillable = ['eventversion_id', 'scoringcomponent_id', 'multiplier', 'proxy_id', 'registrant_id','score', 'user_id'];

    public function registrantScores(\App\Models\Registrant $registrant)
    {
        $scores = $this->where('registrant_id', $registrant->id)
            ->select('score')
            ->orderBy('user_id')
            ->orderBy('scoringcomponent_id')
            ->get()
            ->toArray();

        return array_column($scores,'score');
    }

    public function scoringcomponent()
    {
        return $this->belongsTo(Scoringcomponent::class);
    }

}
