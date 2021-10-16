<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scoresummary extends Model
{
    use HasFactory;

    public $registrant_id;

    protected $fillable = ['eventversion_id', 'instrumentation_id','registrant_id', 'score_count', 'score_total'];

    private $count;
    private $instrumentation_id;
    private $scores;
    private $total;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->count = 0;
        $this->instrumentation_id;
        $this->scores = NULL;
        $this->total = 0;
    }

    public function updateStats()
    {
        $this->scores = Score::where('registrant_id', $this->registrant_id);

        $this->calcCount();

        $this->calcTotal();

        $this->findInstrumentationId();

        $this->updateRow();
    }

/** END OF PUBLIC FUNCTIONS **************************************************/

    private function calcCount()
    {
        $this->count = $this->scores->count();
    }

    private function calcTotal()
    {
        $this->total = $this->scores->sum('score');
    }

    private function findInstrumentationId()
    {
        $registrant = \App\Models\Registrant::find($this->registrant_id);

        $this->instrumentation_id = $registrant->instrumentations()->first()->id;
    }


    private function updateRow()
    {
        $this->updateOrCreate(
            [
               'eventversion_id' => \App\Models\Userconfig::getValue('eventversion', auth()->id()),
               'registrant_id' => $this->registrant_id,
               'instrumentation_id' => $this->instrumentation_id,
           ],
           [
               'score_total' => $this->total,
               'score_count' => $this->count,
           ],
        );
    }
}
