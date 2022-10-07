<?php

namespace App\Http\Controllers\Libraries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function update(Request $request, string $page)
    {
        //dd($page);

        session()->flash('thanks', 'Thanks for your Comments!');

        return back();
    }
}
