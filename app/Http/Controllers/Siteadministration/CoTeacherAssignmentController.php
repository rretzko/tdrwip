<?php

namespace App\Http\Controllers\Siteadministration;

use App\Models\Teacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoTeacherAssignmentController extends Controller
{
    public function store(Request $request)
    {
        $clean = $request->validate([
           'user_ids.*' => ['required','min:1','max:2'],
           'user_ids.0' => ['required','exists:teachers,user_id'],
           'user_ids.1' => ['required','exists:teachers,user_id']
        ]);
        $countUpdates = 0;

        $teacher0 = Teacher::find($clean['user_ids'][0]);

        //probably should be in a service
        //add record to student_teacher if not exists
        foreach($teacher0->myStudentsCurrent() AS $student){

            $found = DB::table('student_teacher')
                ->where('student_user_id', $student->user_id)
                ->where('teacher_user_id', $clean['user_ids'][1])
                ->exists();

            if(! $found) {
                DB::table('student_teacher')
                    ->insert([
                        'student_user_id' => $student->user_id,
                        'teacher_user_id' => $clean['user_ids'][1],
                        'studenttype_id' => 10, //accepted
                        'created_at' => date('Y-n-d G:i:s'),
                        'updated_at' => date('Y-n-d G:i:s'),
                    ]);

                $countUpdates++;
            }
        }

        session()->flash('coteacherassignments', 'Assigned '.$countUpdates.' student records to: ' . $clean['user_ids'][1] . '.');

        return redirect()->route('siteadministrator.index');

    }
}
