<?php

namespace App\Http\Controllers\Ensembles;

use App\Http\Controllers\Controller;
use App\Models\Ensemble;
use App\Models\Ensemblemember;
use App\Models\Schoolyear;
use App\Models\Student;
use App\Models\User;
use App\Models\Userconfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MembersController extends Controller
{
    public function index(Ensemble $ensemble)
    {
        Userconfig::setValue('ensemble_id', auth()->id(), $ensemble->id);

        return view('ensembles.members.index',
            [
                'ensemble' => $ensemble,
                'countmembers' => Ensemblemember::with('person')
                    ->where('ensemble_id', $ensemble->id)
                    ->where('schoolyear_id', Userconfig::getValue('schoolyear_id', auth()->id()))
                    ->count(),
                'schoolyear' => Schoolyear::find(Userconfig::getValue('schoolyear_id', auth()->id())),
            ]);
    }

    /*public function create(Ensemble $ensemble, Schoolyear $schoolyear)
    {
        Userconfig::setValue('ensemble_id', auth()->id(), $ensemble->id);

        return view('ensembles.members.create',
            [
                'ensemble' => $ensemble,
                'schoolyears' => Schoolyear::orderBy('descr', 'desc')->get(),
                'schoolyear' => $schoolyear,
                'nonmembers' => $ensemble->nonmembers(),

            ]);
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ensemblemember $ensemblemember
     * @return Response
     */
    /*public function edit(Ensemblemember $ensemblemember)
    {
        $ensemble = Ensemble::find($ensemblemember->ensemble_id);

        return view('ensembles.members.edit',
            [
                'ensemble' => $ensemble,
                'ensemblemember' => $ensemblemember,
                'schoolyears' => Schoolyear::orderBy('descr', 'desc')->get(),
                'schoolyear' => Schoolyear::find($ensemblemember->schoolyear_id),
                'nonmembers' => $ensemble->nonmembers(),

            ]);
    }
*/
  /*  public function store(Request $request)
    {
        $ensemble_id = Userconfig::getValue('ensemble_id', auth()->id());
        $schoolyear_id = Userconfig::getValue('schoolyear_id', auth()->id());

        foreach($request['nonmembers'] AS $nonmember_id){

            Ensemblemember::updateOrCreate(
                [
                    'ensemble_id' => $ensemble_id,
                    'schoolyear_id' => $schoolyear_id,
                    'user_id' => $nonmember_id,
                    'instrumentation_id' => $this->findInstrumentationId($nonmember_id, $ensemble_id),
                ],
                [
                    'teacher_user_id' => auth()->id()
                ],
            );
        }

        return view('ensembles.members.index',
            [
                'ensemble' => Ensemble::with('ensembletype')->find($ensemble_id),
                'schoolyear_id' => $schoolyear_id,
                'schoolyears' => Schoolyear::orderBy('descr', 'desc')->get(),
                'schoolyear' => Schoolyear::find($schoolyear_id),
            ]);

    }
*/
 /*   private function findInstrumentationId($nonmember_id, $ensemble_id)
    {
        $ensemble = Ensemble::find($ensemble_id)->with('ensembletype')->first();
        $ensembleinstrumentations = $ensemble->ensembletype->instrumentations;
        $user = User::with('instrumentations')->find($nonmember_id);

        foreach($user->instrumentations AS $instrumentation){
            if($ensembleinstrumentations->contains($instrumentation)){

                return $instrumentation->id;
            }
        }

        return $ensembleinstrumentations->first()->id;
    }
*/
}
