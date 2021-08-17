<?php

namespace App\Http\Controllers;

use App\Models\Utility\Dashboard;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request)
    {
        $teachers = collect();
        if(auth()->id() === 368) {
            $teachers = Teacher::with('person')->get()->sortBy('person.last');
        }

        $dashboard = new Dashboard;

        return view('dashboard',[
            'dashboard' => $dashboard,
            'teachers' => $teachers,
        ]);
    }
}
