<?php

namespace App\Http\Livewire\Pitchfiles;

use App\Models\Eventversion;
use App\Models\Userconfig;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Pitchfilecomponent extends Component
{
    public $filecontenttype_id;
    public $eventversion;
    public $filecontenttypes;
    public $instrumentation_id;
    public $instrumentations;

    public function mount()
    {
        $this->eventfiletype_id = 0;
        $this->eventversion = Eventversion::find(Userconfig::getValue('eventversion', auth()->id()));
        $this->instrumentation_id=0;
        $this->instrumentations = $this->instrumentationsArray();
        $this->filecontenttypes = $this->eventversion->filecontenttypes;
    }

    public function render()
    {
        return view('livewire.pitchfiles.pitchfilecomponent',[
            'pitchfiles' => $this->pitchfiles(),
        ]);
    }

    public function updatedFilecontenttypeId()
    {
        $this->pitchfiles();
    }

    public function updatedInstrumentationId()
    {
       $this->pitchfiles();
    }

/** END OF PUBLIC FUNCTIONS  *************************************************/

    private function instrumentationsArray()
    {
        $a = [];

        foreach($this->eventversion->instrumentations() AS $instrumentation){

            $a[$instrumentation->id] = $instrumentation->descr;
        }

        return $a;
}

    private function pitchfiles()
    {
        $instrumentation_id = $this->instrumentation_id;

        if($this->instrumentation_id && $this->filecontenttype_id){

            //isolate rows without instrumentation_id (ex. all voices, pdfs, etc)
            $isnull = DB::table('pitchfiles')
                ->select('id')
                ->where('eventversion_id', $this->eventversion->id)
                ->whereNull('instrumentation_id');

            //combine $isnull with instrumentation_id- and filecontenttype-specific rows
            $all = DB::table('pitchfiles')
                ->select('id')
                ->where('eventversion_id',$this->eventversion->id)
                ->where('instrumentation_id', $this->instrumentation_id)
                ->where('filecontenttype_id', $this->filecontenttype_id)
                ->union($isnull)
                ->get();

            $pitchfiles = collect();
            foreach($all AS $row){

                $pitchfiles->push(\App\Models\Pitchfile::find($row->id));
            }

            return $pitchfiles->sortBy('order_by');

        }elseif($this->filecontenttype_id){

            return $this->eventversion->pitchfiles
                ->where('filecontenttype_id', $this->filecontenttype_id)
                ->sortBy('order_by');

        }elseif($this->instrumentation_id) {

            //isolate rows without instrumentation_id (ex. all voices, pdfs, etc)
            $isnull = DB::table('pitchfiles')
                ->select('id')
                ->where('eventversion_id', $this->eventversion->id)
                ->whereNull('instrumentation_id');

            //combine $isnull with instrumentation_id-specific rows
            $all = DB::table('pitchfiles')
                ->select('id')
                ->where('eventversion_id',$this->eventversion->id)
                ->where('instrumentation_id', $this->instrumentation_id)
                ->union($isnull)
                ->get();

            $pitchfiles = collect();
            foreach($all AS $row){

                $pitchfiles->push(\App\Models\Pitchfile::find($row->id));
            }

            return $pitchfiles->sortBy('order_by');

        }else{

            return $this->eventversion->pitchfiles->sortBy('order_by');
        }

    }
}
