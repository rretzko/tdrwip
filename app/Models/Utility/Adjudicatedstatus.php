<?php

namespace App\Models\Utility;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjudicatedstatus extends Model
{
    use HasFactory;

    private $eventversion;
    private $countscores;
    private $registrant;
    private $registrantscores;
    private $status;

    protected $fillable = ['registrant'];

    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->registrant = $attributes['registrant'];
        $this->eventversion = $this->registrant->eventversion;
        $this->status = 'unauditioned';

        $this->init();
    }

    public function status()
    {
        if($this->unauditioned()){
            return 'unauditioned';
        }elseif($this->tolerance()){
            return 'tolerance';
        }elseif($this->partial()) {
            return 'partial';
        }elseif($this->excess()){
            return 'excess';
        }elseif($this->completed()) {
            return 'completed';
        }else{
            return 'error';
        }
    }
    /** END OF PUBLIC PROPERTIES *************************************************/

    private function init()
    {
        $this->countscores = \App\Models\Scoringcomponent::where('eventversion_id', $this->eventversion->id)->count();
        $scores = new \App\Models\Utility\Registrantscores([ 'registrant' => $this->registrant]);
        $this->registrantscores = $scores->componentscores()->count();
    }

    private function completed()
    {
        return $this->registrantscores === $this->countscores;
    }

    private function excess()
    {
        return $this->registrantscores > $this->countscores;
    }

    private function partial()
    {
        return $this->registrantscores < $this->countscores;
    }

    private function tolerance()
    {
        return false;
    }

    private function unauditioned()
    {
        return (! $this->registrantscores);
    }
}
