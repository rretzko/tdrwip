<?php

namespace App\Http\Controllers\Ensembles;

use App\Http\Controllers\Controller;
use App\Models\Ensemble;
use App\Models\Ensemblemember;
use App\Models\Schoolyear;
use App\Models\Userconfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index(Ensemble $ensemble)
    {
        Userconfig::setValue('ensemble_id', auth()->id(), $ensemble->id);

        return view('ensembles.members.index',
            [
                'ensemble' => $ensemble,
                'schoolyear_id' => Userconfig::getValue('schoolyear_id', auth()->id()),
                'schoolyears' => Schoolyear::orderBy('descr', 'desc')->get(),
                'schoolyear' => Schoolyear::find(Userconfig::getValue('schoolyear_id', auth()->id())),

            ]);
    }

    public function create(Ensemble $ensemble, Schoolyear $schoolyear)
    {
        Userconfig::setValue('ensemble_id', auth()->id(), $ensemble->id);

        return view('ensembles.members.create',
            [
                'ensemble' => $ensemble,
                'schoolyears' => Schoolyear::orderBy('descr', 'desc')->get(),
                'schoolyear' => $schoolyear,
                'nonmembers' => $ensemble->nonmembers(),

            ]);
    }

    public function store(Request $request)
    {
        $ensemble_id = Userconfig::getValue('ensemble_id', auth()->id());
        $schoolyear_id = Userconfig::getValue('schoolyear_id', auth()->id());

        foreach($request['nonmembers'] AS $nonmember_id){

            Ensemblemember::updateOrCreate(
                [
                    'ensemble_id' => $ensemble_id,
                    'schoolyear_id' => $schoolyear_id,
                    'user_id' => $nonmember_id,
                ],
                [
                    'teacher_user_id' => auth()->id()
                ],
            );
        }

        return view('ensembles.members.index',
            [
                'ensemble' => Ensemble::find($ensemble_id),
                'schoolyear_id' => $schoolyear_id,
                'schoolyears' => Schoolyear::orderBy('descr', 'desc')->get(),
                'schoolyear' => Schoolyear::find($schoolyear_id),
            ]);

    }

}
