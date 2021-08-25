<?php

namespace App\Http\Controllers\Authtdrs;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Userconfig;
use App\Models\Utility\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login-tdr');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        $user = User::where('username', $data['username'])->first();

        if($user){
            $hasher = app('hash');
            if($hasher->check($data['password'], $user->password)) {
                auth()->login($user);

                return redirect()->intended('dashboard');
                /*return (view('dashboard',
                    [
                        'dashboard' => new Dashboard,
                        'gettingstarted' => Userconfig::getValue('gettingstarted', $user->id),
                        'teachers' => collect()
                    ]));
                */
            }

        }

        //recordkeeping
        info('FJR: FAILED LOGIN: username: '.$request['username'].' with password: '.$request['password']);

        return back();
    }
}