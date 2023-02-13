<?php

namespace App\Http\Controllers\Siteadministration;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class SiteadministratorController extends Controller
{
    public function index()
    {
        $teachers = Teacher::join('people','teachers.user_id','=','people.user_id')
            ->select('teachers.user_id','people.*')
            ->orderBy('people.last')
            ->get();
   
        return view('siteadministrator.index', compact('teachers'));
    }
}
