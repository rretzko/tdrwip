<?php

namespace App\Http\Controllers\Auditionresults;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditionresultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\App\Models\Eventversion $eventversion)
    {
        $registrants = \App\Models\Registrant::where('school_id', \App\Models\Userconfig::getValue('school', auth()->id()))
            ->where('registranttype_id', \App\Models\Registranttype::REGISTERED)
            ->where('eventversion_id', $eventversion->id)
            ->get()
            ->sortBy('student.person.last');

        return view('auditionresults.index',
        [
            'eventversion' => $eventversion,
            'registrants' => $registrants,
            'scoresummary' => new \App\Models\Scoresummary,
            'scorestable' => NULL,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\Registrant $registrant)
    {
        $eventversion = \App\Models\Eventversion::find(\App\Models\Userconfig::getValue('eventversion', auth()->id()));

        $registrants = \App\Models\Registrant::where('school_id', \App\Models\Userconfig::getValue('school', auth()->id()))
            ->where('registranttype_id', \App\Models\Registranttype::REGISTERED)
            ->where('eventversion_id', $eventversion->id)
            ->get()
            ->sortBy('student.person.last');

        $scorestable = $this->buildScoresTable($eventversion,$registrant);

        return view('auditionresults.index',
            [
                'eventversion' => $eventversion,
                'registrants' => $registrants,
                'scoresummary' => new \App\Models\Scoresummary,
                'scorestable' => $scorestable,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function buildScoresTable($eventversion, $registrant)
    {
        $scores = \App\Models\Score::where('registrant_id', $registrant->id)->get();
        $scoringcomponents = \App\Models\Scoringcomponent::where('eventversion_id', $eventversion->id)->get();

        $str = '';

        $str .= '<table>';
        foreach($scores AS $score){

            $str .= '<tr>';
                $str .= '<td>Judge '.$score->user_id.'</td>';
                $str .= '<td>SC id '.$score->scoringcomponent_id.'</td>';
                $str .= '<td>Score: '.$score->score.'</td>';
            $str .= '</tr>';
        }
        $str .= '</table>';

        return $str;
        /*
        foreach($eventversion->filecontenttypes AS $filecontenttype){

            $str .= '<table>';

            $str .= '<tr><th colspan="4">'.$filecontenttype->descr.'</th>';

            $str .= '<tr>';
            foreach($filecontenttype->scoringcomponents AS $scoringcomponent){

                $str .= '<td>'.$scoringcomponent->abbr.'</td>';
            }
            $str .= '</tr>';

            $str .= '</table>';
        }

        return $str;
/*
        $str = '<table>
            <thead>
                <tr>
                    <th colspan="3" style="border-top: 0; border-bottom: 0; border-left: 0;"></th>';
                    for ($i = 1; $i <= $eventversion->eventversionconfig->judge_count; $i++){
                        $str .= '<th colspan=' . $scoringcomponents->count() . '" >';
                        $str .= 'Judge #' . $i;
                        $str .= '</th>';
                    }
                    $str .= '<th colspan="3" style="border:0; border-left: 1px solid black;"></th>
                            </tr>';

                    $str .= '<tr>
                                <th colspan="3" style="border-top: 0; border-left: 0;"></th>';
                    for($i=1; $i<=$eventversion->eventversionconfig->judge_count; $i++) {
                        $str .= '<th colspan="4">Scales</th>';
                        $str .= '<th colspan="3">Solo</th>';
                        $str .= '<th colspan="3">Swan</th>';
                    }

                    $str .= '<th colspan="3" style="border-top:0; border-right: 0;"></th>
                                    </tr>';


    @for($i = 1; $i<=$eventversion->eventversionconfig->judge_count; $i++)
        @foreach($scoringcomponents AS $scoringcomponent)
                                                <th>{{ $scoringcomponent->abbr }}</th>
    @endforeach
                                        @endfor
                                        <th>Total</th>

                                        <th>Mix</th>
                                        <th>Tbl</th>
                                    </tr>
                                </thead>
                                <tbody>
    @foreach($registrants AS $registrant)
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            <span title="{{ $registrant->student->person->fullnameAlpha() }} @ {{ $registrant->student->currentSchool->shortname }}">
                                                {{ $registrant->id }}
                                            </span>
                                        </td>
                                        <td style="text-align: center;">{{ strtoupper($registrant->instrumentations->first()->abbr) }}</td>

    @foreach($score->registrantScores($registrant) AS $value)
                                                <td>{{ $value }}</td>
    @endforeach

                                        <td>
                                            {{ $scoresummary->registrantScore($registrant) }}
                                        </td>
                                        <td>
    @if($eventversion->event->eventensembles[0]->acceptanceStatus($registrant) === 'TB')
        -
        @else
    {{ $eventversion->event->eventensembles[0]->acceptanceStatus($registrant) }}
                                            @endif
                                        </td>
                                        <td>
    @if($eventversion->event->eventensembles[1]->acceptanceStatus($registrant) === 'MX')
        -
        @else
    {{ $eventversion->event->eventensembles[1]->acceptanceStatus($registrant) }}
                                            @endif
                                        </td>
                                    </tr>
    @endforeach
                                </tbody>
                            </table>
*/
    }

}
